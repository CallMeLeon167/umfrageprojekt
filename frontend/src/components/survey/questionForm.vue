<template>
  <div>
    <h3>Frage hinzufügen</h3>
    <div>
      <label for="question">Frage</label>
      <input type="text" id="question_text" v-model="question.text" />
    </div>
    <div id="questions_answers">
      <label for="question_type">Frage Typ</label>
      <select id="question_type" v-model="question.type">
        <option value="text">Text</option>
        <option value="single_choice">Radio</option>
        <option value="multiple_choice">Checkbox</option>
      </select>
      <ul>
        <li v-for="option in question.answeroptions" :key="JSON.stringify(option)">
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

const question = ref<Object>({
  text: '',
  type: SurveyQuestionType.TEXT,
  answeroptions: []
})
const answerInput = ref('')

const emits = defineEmits(['question_added'])

function onAddAnswer() {
  if (!answerInput.value) return
  const option: SurveyAnswerOption = {
    type: SurveyQuestionType.TEXT,
    text: answerInput.value
  }
  question.value.answeroptions.push(option)
  answerInput.value = ''
}

function onAddQuestion() {
  console.log(question.value)
  emits('question_added', question.value)
  question.value = {
    type: SurveyQuestionType.TEXT,
    options: []
  }
}
</script>
