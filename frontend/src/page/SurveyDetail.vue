<template>
  <span v-if="error" class="error">{{ error }}</span>
  <h2 v-if="!error">Auswertung Umfage {{ survey?.id }}</h2>
  <div v-if="!surveyLoading && !evaluationLoading && !error">
    <h3>{{ survey?.topic }}</h3>
    <span>
      {{ evaluation?.participations }}
      {{ evaluation?.participations > 1 ? "Teilnahmen" : "Teilnahme" }}
    </span>

    <div id="survey-evaluation" v-if="survey">
      <h4>Ergebnisse</h4>
      <ul>
        <li v-for="(question, index) in survey.questions" :key="index">
          <h5>{{ question.questionText }}</h5>
          <ul v-if="question.questionType != 'text'">
            <li v-for="(answer, index) in question.answerOptions" :key="index">
              <div>
                {{ answer.answerOptionText }} ({{countAnswers(question?.questionId, answer.answerOptionID)}}x)
              </div>
            </li>
          </ul>
          <ul v-else>
            <li v-for="(answer, index) in getAnswerTexts(question.questionId)" :key="index">
              {{ answer.Username || "Unbekannt" }}: {{ answer.UserResponse }}
            </li>
          </ul>
        </li>
      </ul>


    </div>

    <div id="comments">
      <h3>Kommentare</h3>
      <span v-if="commentsLoading">Lade Kommentare...</span>
      <ul v-else>
        <li v-for="(comment, index) in comments" :key="index">
          <span>{{ comment.accountName }} : {{ comment.commentText }}</span>
        </li>
      </ul>
    </div>
  </div>

  <div id="loading" v-if="surveyLoading || evaluationLoading">
    <span>Lade Daten...</span>
  </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {useRoute} from "vue-router";
import {FetchError, ofetch} from "ofetch";
import type {Survey, SurveyEvaluation, Comment} from "@/types/survey";
import QuestionAnswerOption from "@/components/survey/questionAnswerOption.vue";

const route = useRoute();

const surveyId = route.params?.id;

const survey = ref<Survey | null>(null);
const surveyLoading = ref(true);
const evaluation = ref<SurveyEvaluation | null>(null);
const comments = ref<Comment[]>([]);
const evaluationLoading = ref(true);
const commentsLoading = ref(true);
const error = ref("");

async function fetchSurvey() {
  survey.value = await ofetch(`/survey/${surveyId}`, {
    method: "GET",
    params: {
      populateQuestions: true,
      populateAnswers: true,
      populateReplys: true,
      populateComments: true,
    },
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
      "Content-Type": "application/json",
    },
  });
  surveyLoading.value = false;
}

async function fetchComments() {
  comments.value = await ofetch("/comment", {
    method: "GET",
    query: {
      surveyId: surveyId,
    },
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
      "Content-Type": "application/json",
    },
  });
  commentsLoading.value = false;
}

async function fetchEvaluation() {
  try {
    evaluation.value = await ofetch(`/survey-evaluation/${surveyId}`, {
      method: "GET",
      baseURL: import.meta.env.VITE_API_URL,
      headers: {
        "Content-Type": "application/json",
      },
    });
    evaluationLoading.value = false;
  } catch (err) {
    const fetchError = err as FetchError;
    if (fetchError.response?.status === 404) {
      error.value = "An dieser Umfrage hat noch niemand teilgenommen.";
      evaluationLoading.value = false;
      surveyLoading.value = false;
    } else {
      error.value = "Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut." + fetchError.message;
    }
    console.error(error);
  }
}

function countAnswers(questionId: string, answerOptionId: string): number {
  return evaluation.value?.filter((entry) => {
    return entry.QuestionId === questionId && entry.AnswerOptionId === answerOptionId;
  }).length || 0;
}

function getAnswerTexts(questionId: string) {
  // return all entries in evaluation that have the given questionId
  const entries = evaluation.value?.filter((entry) => {
    return entry.QuestionId === questionId;
  }) || [];

  // return only fields UserResponse and Username
  return entries.map((entry) => {
    return {
      UserResponse: entry.UserResponse,
      Username: entry.Username,
    };
  });
}

fetchSurvey();
fetchEvaluation();
fetchComments();
</script>


<style scoped>
h2 {
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

h3 {
  color: #444;
  margin-bottom: 10px;
}

span {
  display: block;
  color: #666;
  margin-bottom: 20px;
}

.error {
  color: white;
  text-align: center;
  background: #ff6969;
  width: 70%;
  margin: 20px auto;
  padding: 20px;
  border-radius: 8px;
}

#survey-evaluation {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
}

#survey-evaluation h4 {
  color: #555;
  margin-bottom: 10px;
}

#survey-evaluation ul {
  list-style-type: none;
  padding: 0;
}

#survey-evaluation li {
  background: #f9f9f9;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 10px;
}

#comments {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#comments h3 {
  color: #444;
}

#comments ul {
  list-style-type: none;
  padding: 0;
}

#comments li {
  background: #f9f9f9;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 10px;
}

#loading {
  text-align: center;
  color: #777;
  font-size: 18px;
  margin-top: 20px;
}
</style>