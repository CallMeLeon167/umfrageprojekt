<template>
  <h2>Kategorieles</h2>
  <button @click="createSurvey">Umfägele erstellen</button>

  <button @click="fetchSurveys">Umfägeles laden</button>
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
  <div v-else>
    Lade Umfägeles...
  </div>

</template>

<script setup lang="ts">

import { useRouter } from 'vue-router'
import { ref } from "vue";
import { ofetch } from "ofetch";
import type { Survey } from "@/types/survey";

const router = useRouter();

const surveys = ref<Survey[]>([])
const isLoading = ref(true)

const createSurvey = () => {
  router.push('/admin/survey/create')
}

const fetchSurveys = async () => {
  const API_URL = import.meta.env.VITE_API_URL;
  isLoading.value = true;
  const response = await ofetch('/survey', {
    baseURL: API_URL,
    method: 'GET',
  });
  console.log(response);
  if (response) {
    surveys.value = response;
  }
  isLoading.value = false;
}

const onDeleteSurvey = async (id: string) => {
  const API_URL = import.meta.env.VITE_API_URL;
  await ofetch(`/survey/${id}`, {
    baseURL: API_URL,
    method: 'DELETE',
  });
  await fetchSurveys();
}

const formatDate = (dateString: Date) => {
  const date = new Date(dateString)
  return date.toLocaleString('de-DE', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

fetchSurveys();
</script>
