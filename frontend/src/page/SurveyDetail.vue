<template>
  <div>
    <h2>Umfägele {{ id }}</h2>
    dö hän soo viele leid gschribe dass die sache scheiße finne
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const id = computed(() => route.params?.id || 'kää Id')
</script>
