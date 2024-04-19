<template>
  <div>
    <h3>Frage hinzufügen</h3>
    <div>
      <label for="question">Frage</label>
      <input type="text" id="question_text" />
    </div>
    <br />
    <div id="questions_answers">
      <label for="question_type">Frage Typ</label>
      <select id="question_type">
        <option value="text">Text</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
      </select>
      <ul>
        <li v-for="answer in question.answers" :key="answer">
          {{ answer }}
        </li>
      </ul>
      <label for="question_option">Antwort</label>
      <input type="text" id="question_option" v-model="answerInput" />
      <button type="button" id="add-option" @click="onAddAnswer()">Option hinzufügen</button>
    </div>
    <button type="button" id="add-question" @click="onAddQuestion()">Frage hinzufügen</button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const props
const question = ref({
  question: '',
  type: 'text',
  answers: []
})
const answerInput = ref('')

function onAddAnswer() {
  if (!answerInput.value) return
  question.value.answers.push(answerInput.value as string)
  answerInput.value = ''
}

function onAddQuestion() {
  console.log(question.value)
}
</script>
