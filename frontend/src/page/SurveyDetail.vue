<template>
  <h2>Auswertung Umfage {{survey?.id}}</h2>
  <div v-if="!surveyLoading && !evaluationLoading">
    <h3>{{survey?.topic}}</h3>
    <span>{{evaluation?.participations}} {{evaluation?.participations > 1 ? "Teilnahmen" : "Teilnahme"}}</span>
    <div id="survey-evaluation" v-if="survey">
      <div v-for="(question, index) in evaluation?.answers">
        <h4 v-if="survey.questions">{{ survey?.questions[index-1]?.questionText }}</h4>
        <ul>
          <li v-for="answer in question">
            {{answer}}
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div id="loading" v-if="surveyLoading || evaluationLoading">
    <span>Lade Daten...</span>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { ofetch } from "ofetch";
import type {Survey, SurveyEvaluation} from "@/types/survey";

const route = useRoute();

const surveyId = route.params?.id;

const survey = ref<Survey | null>(null);
const surveyLoading = ref(true);
const evaluation = ref<SurveyEvaluation | null>(null);
const evaluationLoading = ref(true);

async function fetchSurvey() {
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
  surveyLoading.value = false;
}

async function fetchEvaluation() {
  evaluation.value = await ofetch(`/survey-evaluation/${surveyId}`, {
    method: 'GET',
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
      'Content-Type': 'application/json'
    }
  });
  evaluationLoading.value = false;
}

fetchSurvey();
fetchEvaluation();

</script>
