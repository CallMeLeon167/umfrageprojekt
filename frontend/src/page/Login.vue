<template>
  <div>
    <from>
      <h1>Login</h1>
      <label for="username">Username</label>
      <input type="text" placeholder="Username" />
      <label for="password">Password</label>
      <input type="password" placeholder="Password" />
      <button @click="auth.login">Login</button>
    </from>
    <pre>auth:{{ auth }}</pre>
  </div>
</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'
import { ofetch } from 'ofetch'
import { ref } from 'vue'

const username = ref('')
const password = ref('')
const auth = useAuth()
const API_URL = import.meta.env.VITE_API_URL
</script>
