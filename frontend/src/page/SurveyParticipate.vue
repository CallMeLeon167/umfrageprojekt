<template>
  <h2>Umfrage {{ route.params?.id }}</h2>
  <p>Bitte fülle die Umfrage aus.</p>
  <p>Die Umfrage hat die ID {{ route.params?.id }}</p>
  <p>Errors: {{ errors }}</p>
  <pre>
    {{ survey }}
  </pre>
</template>

<script setup>
import { ofetch } from 'ofetch';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const surveyId = route.params?.id;
const errors = ref([]);
const survey = ref(null);

async function fetchSurvey() {
  if (!surveyId) {
    errors.value.push('Survey ID is missing');
    return;
  }
  const response = await ofetch(`/survey/${surveyId}`, {
    method: 'GET',
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
      'Content-Type': 'application/json'
    }
  });
  if (!response.ok) {
    errors.value.push('Failed to fetch survey');
    return;
  }
  survey.value = response;
}

fetchSurvey();
</script>
