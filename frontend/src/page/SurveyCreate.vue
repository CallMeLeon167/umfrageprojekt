<template>
  <h2>Create Survey</h2>
  <div>
    <form id="survey-create-form" @submit.prevent="onSubmitSurvey()">
      <div>
        <label for="title">Title</label>
        <input type="text" id="title" v-model="form.title" />
      </div>
      <select id="category">
        <option value="1">Category 1</option>
        <option value="2">Category 2</option>
        <option value="3">Category 3</option>
      </select>
      <div>
        <label for="start_date">Start Date</label>
        <input type="date" id="start_date" />
      </div>
      <div>
        <label for="end_date">End Date</label>
        <input type="date" id="end_date" />
      </div>

      <!-- status -->
      <div>
        <label for="status">Status</label>
        <select id="status">
          <option v-bind:key="option" :value="option" v-for="option in surveyStateOptions">
            {{ option }}
          </option>
        </select>
      </div>
      <!-- topic (comment/description) input -->

      <!-- startdatum / enddatum  -->

      <!-- CATEGORY DROPDOWN -->

      <!-- questions list -->
      <div>
        Questions:
        <pre>
          {{ form.questions }}
        </pre>
      </div>
      <QuestionForm @question_added="onAddQuestion" />

      <button type="submit">Umfrage einreichen</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import QuestionForm from '@/components/survey/questionForm.vue'
import { ref } from 'vue'
import { SurveyState, type SurveyQuestion } from '@/types/survey'
import { $fetch, ofetch } from 'ofetch'

const questionForm = ref<Object>({})

const form = ref({
  title: '',
  questions: [] as SurveyQuestion[]
})

const surveyStateOptions = Object.values(SurveyState)

function onAddQuestion(question: SurveyQuestion) {
  console.log(question)
  if (!question) return
  form.value.questions.push(JSON.parse(JSON.stringify(question)))
}

async function onSubmitSurvey() {
  console.log(form.value)
  const response = await $fetch('/survey', {
    method: 'POST',
    body: JSON.stringify(form.value)
  })
  console.log(response)
  if (response.ok) {
    alert('Survey created')
  } else {
    alert('Error creating survey')
  }
}
</script>
