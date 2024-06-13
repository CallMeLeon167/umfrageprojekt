<template>
  <h3>{{ question.questionText }}</h3>
  <ul class="question-answerOptions">
    <li v-for="option in question.answerOptions" :key="option.answerOptionID">
      {{ option.answerOptionText}}
    </li>
  </ul>
  <button @click="onAnswerAdded('yes')">Yes</button>
  <button @click="onAnswerAdded('no')">No</button>
</template>

<script setup lang="ts">

import {type PropType, ref} from 'vue'
import type {SurveyQuestion} from "@/types/survey";

const props = defineProps({
  question: {
    type: Object as PropType<SurveyQuestion>,
    required: true
  }
});

const emits = defineEmits(['answer_added']);

function onAnswerAdded(answer: string) {
  emits('answer_added', props.question?.text, answer);
}

</script>