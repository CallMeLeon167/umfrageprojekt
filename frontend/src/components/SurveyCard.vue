<template>
    <div class="home__left">
      <h2>Letzte Umfrage</h2>
      <div class="last-survey">
        <div>
          <h3>Titel</h3>
          <p>Bescreibung</p>
        </div>
        <RouterLink :to="`/survey/`" class="btn-right">
          <button>An Umfrage Teilnehmen</button>
        </RouterLink>
      </div>
    </div>
</template>
  
  <script setup lang="ts">
  const props = defineProps({
      imageUrl: {
        type: String,
        required: false,
        default: 'Avatar'
      },
    }
  );
  </script>
  
  <style scoped>
.last-survey {
  padding: 20px;
  border-radius: 7px;
  border: 2px solid var(--border);
  margin: 20px;
}

.last-survey h3,
.last-survey p {
  margin: 0;
}

.btn-right {
  display: flex;
  justify-content: flex-end;
  text-decoration: none;
}
  </style>