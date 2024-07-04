<template>
  <div>
    <h3>Frage hinzufügen</h3>
    <div>
      <label for="question">Frage</label>
      <input type="text" id="question_text" />
    </div>
    <div id="questions_answers">
      <label for="question_type">Frage Typ</label>
      <select id="question_type">
        <option value="text">Text</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
      </select>
      <ul>
        <li v-for="option in question.options" :key="JSON.stringify(option)">
          {{ option }}
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
import { defineEmits } from 'vue'
import { SurveyQuestionType, type SurveyQuestion, type SurveyAnswerOption } from '@/types/survey'

const question = ref<SurveyQuestion>({
  text: '',
  type: SurveyQuestionType.TEXT,
  options: []
})
const answerInput = ref('')

const emits = defineEmits(['question_added'])

function onAddAnswer() {
  if (!answerInput.value) return
  const option: SurveyAnswerOption = {
    type: SurveyQuestionType.TEXT,
    text: answerInput.value
  }
  question.value.options.push(option)
  answerInput.value = ''
}

function onAddQuestion() {
  console.log(question.value)
  emits('question_added', question.value)
  question.value = {
    text: '',
    type: SurveyQuestionType.TEXT,
    options: []
  }
}
</script>
