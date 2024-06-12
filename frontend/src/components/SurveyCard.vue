<template>
  <div class="survey-card">
    <div>
      <h3>{{ survey.topic }}</h3>
      <p>{{ survey.type }}</p>
    </div>
    <RouterLink :to="`/survey/` + survey.id" class="btn-right">
      <button>An Umfrage Teilnehmen</button>
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
import type { Survey } from '@/types/survey'
import type { PropType } from 'vue'

const props = defineProps({
  survey: {
    type: Object as PropType<Survey>,
    required: true
  }
})
</script>

<style>
.survey-card {
  padding: 20px;
  border-radius: 7px;
  border: 2px solid var(--border);
  margin: 20px;
}

.survey-card h3,
.survey-card p {
  margin: 0;
}

.btn-right {
  display: flex;
  justify-content: flex-end;
  text-decoration: none;
}
</style>
