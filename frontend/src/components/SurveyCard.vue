<template>
  <div class="survey-card">
    <div class="survey-card_body">
      <h3>{{ survey.topic }}</h3>
      <p>{{ survey.type }}</p>
    </div>
    <div class="action-buttons">
      <RouterLink :to="`/survey/` + survey.id + '/detail'" class="btn-right">
        <button>Umfrage ansehen</button>
      </RouterLink>
      <RouterLink :to="`/survey/` + survey.id + '/participate'" class="btn-right">
        <button>An Umfrage Teilnehmen</button>
      </RouterLink>
    </div>
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

.survey-card_body {
  margin-bottom: 10px;
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

.action-buttons {
  display: flex;
  justify-self: flex-end;
  justify-content: space-between;
}
</style>
