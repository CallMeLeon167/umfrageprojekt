<template>
  <div v-if="route.name == 'admin'">
    <h2>Admin</h2>
    <h3>Zeige Board von:</h3>
    <button>
      <RouterLink to="/admin/category">Kategorien</RouterLink>
    </button>
    <button>
      <RouterLink to="/admin/survey">Umfragen</RouterLink>
    </button>
  </div>
  <router-view>
  </router-view>
</template>

<script setup lang="ts">
import { RouterLink, useRoute } from 'vue-router';
const route = useRoute();
</script>

<style scoped>
button a {
  text-decoration: none;
  color: black;
}

button {
  margin-right: 10px;
}
</style>