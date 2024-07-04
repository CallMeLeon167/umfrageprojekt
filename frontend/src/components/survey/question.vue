<template>
  <div class="question">
    <h3>{{ question.questionText }}</h3>
    <div v-for="answer in question.answerOptions" :key="answer.answerOptionID" class="answer-option">
      <input :type="inputType" :id="`input-${answer.answerOptionID}`" :name="question.questionId"
        @input="onAnswerAdded($event, question.questionId, answer.answerOptionID)">
      <label :for="`input-${answer.answerOptionID}`">{{ answer.answerOptionText }}</label>
    </div>
    <div v-if="question.questionType === SurveyQuestionType.TEXT" class="answer-option">
      <input type="text" :id="`input-text-${question.questionId}`" :name="question.questionId"
        @input="onAnswerAdded($event, question.questionId)">
    </div>
  </div>
</template>

<script setup lang="ts">

import { computed, type PropType, ref } from 'vue'
import { type SurveyQuestion, SurveyQuestionType } from "@/types/survey";
import QuestionAnswerOption from "@/components/survey/questionAnswerOption.vue";

const props = defineProps({
  question: {
    type: Object as PropType<SurveyQuestion>,
    required: true
  }
});

const emits = defineEmits(['answer_added']);

const inputType = (() => {
  switch (props.question.questionType) {
    case SurveyQuestionType.TEXT:
      return 'text';
    case SurveyQuestionType.MULTIPLE_CHOICE:
      return 'checkbox';
    case SurveyQuestionType.SINGLE_CHOICE:
      return 'radio';
    default:
      return 'text';
  }
})();

function onAnswerAdded(event: Event, questionId?: string, answerId?: string) {
  const text = props.question.questionType === SurveyQuestionType.TEXT ? (event.target as HTMLInputElement).value : undefined;
  emits('answer_added', questionId, answerId, text);
}

</script>

<style scoped>
.answer-option {
  display: flex;
  gap: 10px;
}
</style>