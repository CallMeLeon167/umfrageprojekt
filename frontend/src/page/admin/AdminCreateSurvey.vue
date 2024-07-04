<template>
  <h2 class="survey-create-title">Umfrage erstellen</h2>
  <div>
    <form id="survey-create-form" @submit.prevent="onSubmitSurvey()">
      <div>
        <label for="title">Title</label>
        <input type="text" id="title" v-model="form.title" />
      </div>
      <div>
        <label for="category">Umfragenkategorie:</label>
        <select id="category" :disabled="categories.length === 0">
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }} ({{ category.type }})
          </option>
        </select>
      </div>
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
        <h3>
          Questions:
        </h3>
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
import { SurveyState, type SurveyQuestion, type Category } from '@/types/survey'
import { $fetch, ofetch } from 'ofetch'

const questionForm = ref<Object>({})

const API_URL = import.meta.env.VITE_API_URL

const form = ref({
  title: '',
  questions: [] as SurveyQuestion[]
});

const categories = ref<Category[]>([]);

const surveyStateOptions = Object.values(SurveyState)

function onAddQuestion(question: SurveyQuestion) {
  console.log(question)
  if (!question) return
  form.value.questions.push(JSON.parse(JSON.stringify(question)))
}

async function loadCategories() {
  const response = await ofetch('/category', {
    baseURL: API_URL,
    method: 'GET'
  });
  categories.value = response || [];
}

async function onSubmitSurvey() {
  console.log(form.value)
  const response = await ofetch('/survey', {
    baseURL: API_URL,
    method: 'POST',
    body: JSON.stringify(form.value)
  })
  console.log(response)
  if (response) {
    alert('Survey created')
  } else {
    alert('Error creating survey')
  }
}

loadCategories();
</script>


<style>
.survey-create-title {
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

#survey-create-form {
  max-width: 600px;
  margin: 0 auto;
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#survey-create-form div {
  margin-bottom: 15px;
}

#survey-create-form label {
  display: block;
  margin-bottom: 5px;
  color: #555;
}

#survey-create-form input[type="text"],
#survey-create-form input[type="date"],
#survey-create-form select {
  width: 100%;
  outline: none;
  border: 1px solid #c9c9c9;
  border-radius: 10px;
  padding: 12px;
  background: var(--background);
  transition: border 0.2s;
  box-sizing: border-box;
}

#survey-create-form input[type="text"]:focus,
#survey-create-form input[type="date"]:focus,
#survey-create-form select:focus {
  border-color: #333;
}

#survey-create-form button {
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

#survey-create-form button:hover {
  background-color: #555;
}

#survey-create-form h3 {
  color: #333;
  margin-bottom: 10px;
}

#survey-create-form pre {
  background: #f9f9f9;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ddd;
}
</style>