<template>
  <div class="answer-option" v-if="answerType === SurveyQuestionType.TEXT">
    <label :for="`input-${answerOption.answerOptionID}`">{{ answerOption.answerOptionText }}</label>
    <input type="text" :id="`input-${answerOption.answerOptionID}`" />
  </div>
  <div class="answer-option" v-else-if="answerType === SurveyQuestionType.SINGLE_CHOICE">
    <input type="radio" :id="`input-${answerOption.answerOptionID}`" />
    <label :for="`input-${answerOption.answerOptionID}`">{{ answerOption.answerOptionText }}</label>
  </div>
  <div class="answer-option" v-else-if="answerType === SurveyQuestionType.MULTIPLE_CHOICE">
    <input type="checkbox" :id="`input-${answerOption.answerOptionID}`" >
    <label :for="`input-${answerOption.answerOptionID}`">{{ answerOption.answerOptionText }}</label>
  </div>
</template>

<script setup lang="ts">

import type {PropType} from "vue";
import {type SurveyAnswerOption, SurveyQuestionType} from "@/types/survey";

const props = defineProps({
  answerOption: {
    type: Object as PropType<SurveyAnswerOption>,
    required: true
  },
  answerType: {
    type: String as PropType<SurveyQuestionType>,
    required: true
  }
});

</script>

<style scoped>
.answer-option {
  padding-left: 1.5em;
  display: flex;
  gap: 10px;
}
</style>