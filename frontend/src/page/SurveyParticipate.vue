<template>
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
      <span class="self-end">{{survey?.startdate}} - {{survey?.enddate}}</span>
    </div>
  </div>
  <div v-if="survey">
    <question v-for="question in survey.questions" :key="question.id" :question="question" @answer_added="onAnswerAdded" />
  </div>
</template>

<script setup lang="ts">

import {ofetch} from 'ofetch';
import {ref} from 'vue';
import {useRoute} from 'vue-router';
import type {Survey} from "@/types/survey";
import Question from "@/components/survey/question.vue";

const route = useRoute();
const surveyId = route.params?.id;
const errors = ref<string[]>([]);
const survey = ref<Survey | null>(null);

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

function onAnswerAdded(questionId: string, answer: string) {
  console.log('Answer added', questionId, answer);
}

fetchSurvey();
</script>

<style>
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

.self-end {
  align-self: flex-end;
}
</style>
