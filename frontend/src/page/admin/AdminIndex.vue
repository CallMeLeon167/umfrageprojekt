<template>
  <h3>Zeige Board von:</h3>
  <button>
    <RouterLink to="/admin/category">Kategorien</RouterLink>
  </button>
  <button>
    <RouterLink to="/admin/survey">Umfragen</RouterLink>
  </button>
  <router-view>
  </router-view>
</template>

<script setup lang="ts">

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