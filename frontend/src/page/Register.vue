<template>
  <div>
    <from>
      <h1>Registrieren</h1>
      <label for="username">Username</label>
      <input type="text" placeholder="Username" />
      <label for="password">Password</label>
      <input type="password" placeholder="Password" />
      <button @click="auth.register">Account erstellen</button>
    </from>
  </div>
</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'

const auth = useAuth()
</script>
