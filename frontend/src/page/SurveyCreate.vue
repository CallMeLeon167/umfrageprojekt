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
      <QuestionForm />
    </form>
  </div>
</template>

<script setup lang="ts">
import QuestionForm from '@/components/survey/questionForm.vue'
import { ref } from 'vue'

const form = ref({
  title: ''
})
</script>
