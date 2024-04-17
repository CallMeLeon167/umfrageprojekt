<template>
  <h2>Create Survey</h2>
  <div>
    <form id="survey-create-form">
      <div>
        <label for="title">Title</label>
        <input type="text" id="title" v-model="form.title" />
      </div>
      <!-- topic (comment/description) input -->

      <!-- startdatum / enddatum  -->

      <!-- CATEGORY DROPDOWN -->

      <!-- questions list -->

      <div id="survey-question-form">
        <h3>Frage hinzufügen</h3>
        <div>
          <label for="question">Frage</label>
          <input type="text" id="question_text" />
        </div>
        <div id="questions_answers"></div>
        <div>
          <label for="question_type">Frage Typ</label>
          <select id="question_type">
            <option value="text">Text</option>
            <option value="radio">Radio</option>
            <option value="checkbox">Checkbox</option>
          </select>

          <div id="question-options">
            <label for="question_option">Antwort</label>
            <input type="text" id="question_option" />
            <button type="button" id="add-option">Option hinzufügen</button>
          </div>

          <button type="button" id="add-question">Frage hinzufügen</button>
        </div>
      </div>

      <!-- submit button -->
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const form = ref({
  title: ''
})
</script>
