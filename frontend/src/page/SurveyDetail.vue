<template>
  <h2>Auswertung Umfage {{ survey?.id }}</h2>
  <div v-if="!surveyLoading && !evaluationLoading">
    <h3>{{ survey?.topic }}</h3>
    <span>
      {{ evaluation?.participations }}
      {{ evaluation?.participations > 1 ? "Teilnahmen" : "Teilnahme" }}
    </span>
    <div id="survey-evaluation" v-if="survey">
      <div v-for="(question, index) in evaluation?.answers" :key="index">
        <h4 v-if="survey.questions">{{ survey?.questions[index - 1]?.questionText }}</h4>
        <ul>
          <li v-for="(answer, index) in question" :key="index">
            {{ answer }}
          </li>
        </ul>
      </div>
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
import { ref } from "vue";
import { useRoute } from "vue-router";
import { ofetch } from "ofetch";
import type { Survey, SurveyEvaluation, Comment } from "@/types/survey";

const route = useRoute();

const surveyId = route.params?.id;

const survey = ref<Survey | null>(null);
const surveyLoading = ref(true);
const evaluation = ref<SurveyEvaluation | null>(null);
const comments = ref<Comment[]>([]);
const evaluationLoading = ref(true);
const commentsLoading = ref(true);

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
  evaluation.value = await ofetch(`/survey-evaluation/${surveyId}`, {
    method: "GET",
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
      "Content-Type": "application/json",
    },
  });
  evaluationLoading.value = false;
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