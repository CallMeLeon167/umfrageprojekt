<template>
  <h2>Umfrägeles</h2>
  <div class="survey-list" v-if="!isLoading && !error">
    <SurveyCard v-for="survey in surveys" :key="survey.id" :survey="survey" />
  </div>
  <div v-else-if="isLoading">
    <p>Lade Umfrägeles...</p>
  </div>
  <div v-else-if="error">
    <p>{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import SurveyCard from '@/components/SurveyCard.vue'
import type { Survey } from '@/types/survey'
import { ofetch } from 'ofetch'
import { ref } from 'vue'

const surveys = ref<Survey[]>([])
const isLoading = ref(true)
const error = ref('')

const fetchSurveys = async () => {
  const API_URL = import.meta.env.VITE_API_URL
  const response = await ofetch('/survey', {
    baseURL: API_URL,
    method: 'GET'
  })
  if (response) {
    surveys.value = response
  } else {
    error.value = 'No response'
    console.log('No response')
  }
  isLoading.value = false
}

fetchSurveys()
</script>
