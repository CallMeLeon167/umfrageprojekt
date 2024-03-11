<script setup lang="ts">
import { watchEffect } from 'vue'
import { RouterView, useRoute } from 'vue-router'
import Layout from './layout/layout.vue'

const route = useRoute()

watchEffect(() => {
  document.title = "Umfrage Portal - " + route.meta.title || 'Umfrage Portal'
})
</script>

<template>
  <Layout>
    <RouterView />
  </Layout>
</template>
