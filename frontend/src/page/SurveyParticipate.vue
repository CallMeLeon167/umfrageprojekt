<template>
  <div class="survey-container">
    <p v-if="errors.length > 0" class="error-notification">
      Errors: {{ errors }}
    </p>
    <div class="survey-head">
      <div>
        <h2 class="title">{{ survey?.topic }}</h2>
        <span class="subtitle">{{ survey?.type }}</span>
      </div>
      <div class="flex flex-col">
        <span class="self-end">Status: {{ survey?.status }}</span>
        <span class="self-end">{{ survey?.startdate }} - {{ survey?.enddate }}</span>
      </div>
    </div>
    <form v-if="survey" @submit.prevent="onSubmitSurvey">
      <question v-for="question in survey.questions" :key="question.questionId" :question="question"
        @answer_added="onAnswerAdded" />
      <button type="submit">Submit</button>
    </form>
  </div>

</template>

<script setup lang="ts">

import { FetchError, ofetch } from 'ofetch';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import type { Survey } from "@/types/survey";
import Question from "@/components/survey/question.vue";
import { useAuth } from "@/composables/useAuth";

const route = useRoute();
const router = useRouter();
const auth = useAuth();
const surveyId = route.params?.id;
const errors = ref<string[]>([]);
const survey = ref<Survey | null>(null);
// answers ref is a map of questionId to answerId and answer text if set
const answers = ref<Map<string, { answerId: string, answer?: string }>>(new Map());

async function fetchSurvey() {
  if (!surveyId) {
    errors.value.push('Survey ID is missing');
    return;
  }
  try {
    survey.value = await ofetch(`/survey/${surveyId}`, {
      method: 'GET',
      params: {
        populateQuestions: true,
        populateAnswers: true
      },
      baseURL: import.meta.env.VITE_API_URL,
      headers: {
        'Content-Type': 'application/json'
      }
    });
  } catch (e) {
    errors.value.push('Failed to fetch survey');
    errors.value.push(e.toString());
  }
}

function onAnswerAdded(questionId: string, answerId: string, answer?: string) {
  console.log('Answer added', questionId, answerId, answer);
  if (!questionId) {
    errors.value.push('Question ID is missing');
    return;
  }
  answers.value.set(questionId, { answerId, answer });
}

async function onSubmitSurvey() {
  // check if answers are not empty
  if (answers.value.size === 0) {
    errors.value.push('No answers provided');
    return;
  }
  // convert answers to json {questionId, answerId, answer}}
  const answersJson = Array.from(answers.value).map(([questionId, { answerId, answer }]) => ({
    questionId,
    answerId,
    answer
  }));
  console.log('Submitting answers', answersJson);
  const body = {
    surveyId: surveyId,
    userId: auth.session.user?.id,
    answers: answersJson
  };
  try {
    const result = await ofetch("/surveyParticipation", {
      method: 'POST',
      params: {
        XDEBUG_SESSION_START: 'PHPSTORM'
      },
      baseURL: import.meta.env.VITE_API_URL,
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(body)
    });
    // redirect to survey list
    await router.push('/survey');
    // e of type FetchError
  } catch (e) {
    const error = e as FetchError;
    switch (error.status) {
      case 400:
        errors.value.push('Bad request');
        break;
      case 401:
        errors.value.push('Unauthorized');
        break;
      case 403:
        errors.value.push('Survey already submitted');
        break;
      case 404:
        errors.value.push('Survey not found');
        break;
      case 500:
        errors.value.push('Internal server error');
        break;
      default:
        errors.value.push('Unknown error');
    }

  }


}

fetchSurvey();

</script>

<style scoped>
.title {
  font-size: 1.5em;
  margin-bottom: .2em;
}

.subtitle {
  font-size: .9em;
  color: #666;
}

.error-notification {
  background-color: lightcoral;
  color: white;
  padding: 1em;
  margin-top: 1em;
  border-radius: .6em;
}

.survey-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1em;
}

.flex {
  display: flex;
}

.flex-col {
  flex-direction: column;
}

.survey-container {
  max-width: 800px;
  margin: 0 auto;
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.survey-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.title {
  font-size: 24px;
  color: #333;
}

.subtitle {
  font-size: 18px;
  color: #777;
}

.self-end {
  align-self: flex-end;
  margin-top: 5px;
  font-size: 14px;
  color: #555;
}

form button {
  margin-top: 10px;
  display: block;
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 10px;
  background-color: #333;
  color: white;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.2s;
}

form button:hover {
  background-color: #555;
}
</style>
