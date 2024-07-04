<template>
  <h2>Umfragen</h2>
  <button @click="createSurvey">Umfragen erstellen</button>

  <button @click="fetchSurveys">Umfragen laden</button>
  <table class="survey-table" v-if="!isLoading">
    <thead>
      <tr>
        <th>ID</th>
        <th>Thema</th>
        <th>Type</th>
        <th>Startet am</th>
        <th>Endet am</th>
        <th>Status</th>
        <th>Kategorie ID</th>
        <th>Optionen</th>
      </tr>
    </thead>
    <tbody v-if="surveys.length > 0">
      <tr v-for="survey in surveys" :key="survey.id">
        <td>{{ survey.id }}</td>
        <td>{{ survey.topic }}</td>
        <td>{{ survey.type }}</td>
        <td>{{ formatDate(survey.startdate) }}</td>
        <td>{{ formatDate(survey.enddate) }}</td>
        <td>{{ survey.status }}</td>
        <td>{{ survey.categoryID }}</td>
        <td>
          <button disabled>Bearbeiten</button>
          <button @click="onDeleteSurvey(survey.id)">Löschen</button>
        </td>
      </tr>
    </tbody>
    <tbody v-else>
      <tr>
        <td colspan="3">Keine Umfägeles vorhanden</td>
      </tr>
    </tbody>
  </table>
  <div v-else>Lade Umfägeles...</div>
  <confirmModal :show="showConfirmModal" @confirm="deleteSurvey" :title="modalOptions.title"
    :description="modalOptions.description" :confirm-text="modalOptions.confirmText" />
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import { ofetch } from 'ofetch'
import type { Survey } from '@/types/survey'
import confirmModal from '@/components/confirmModal.vue'

const router = useRouter()

const surveys = ref<Survey[]>([])
const isLoading = ref(true)
const showConfirmModal = ref(false)
const surveyToDelete = ref<string | null>(null)
const modalOptions = ref({
  title: 'Bestätigen',
  description: 'Sicher?',
  confirmText: 'Bestätigen'
})

const createSurvey = () => {
  router.push('/admin/survey/create')
}

const fetchSurveys = async () => {
  const API_URL = import.meta.env.VITE_API_URL
  isLoading.value = true
  const response = await ofetch('/survey', {
    baseURL: API_URL,
    method: 'GET'
  })
  console.log(response)
  if (response) {
    surveys.value = response
  }
  isLoading.value = false
}

const onDeleteSurvey = async (id: string) => {
  modalOptions.value.title = 'Löschen?'
  modalOptions.value.description = 'Möchten Sie diese Umfrage sicher löschen?'
  modalOptions.value.confirmText = 'Ja'
  surveyToDelete.value = id
  console.log('show delete confirmation')
  showConfirmModal.value = true
  console.log(showConfirmModal.value)
}

const deleteSurvey = async () => {
  showConfirmModal.value = false
  const API_URL = import.meta.env.VITE_API_URL
  if (!surveyToDelete.value) {
    return
  }
  await ofetch(`/survey/${surveyToDelete.value}`, {
    baseURL: API_URL,
    method: 'DELETE'
  })
  surveyToDelete.value = null
  await fetchSurveys()
}

const formatDate = (dateString: Date) => {
  const date = new Date(dateString)
  return date.toLocaleString('de-DE', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

fetchSurveys()
</script>
