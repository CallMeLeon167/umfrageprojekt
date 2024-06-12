<template>
  <h2>Umfrage {{ route.params?.id }}</h2>
  <p>Bitte fülle die Umfrage aus.</p>
  <p>Die Umfrage hat die ID {{ route.params?.id }}</p>
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()
</script>
