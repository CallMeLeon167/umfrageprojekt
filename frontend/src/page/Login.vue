<template>
  <div class="login-container">
    <div class="login-content">
      <div class="login-header">
        <div class="login-header_left">
          <img src="/src/assets/logo.png" alt="logo" />
          <span class="app-name">Umfrage Portal</span>
        </div>
      </div>
      <div class="login-body">
        <h2>Login</h2>
        <form @submit.prevent="login()">
          <label for="user">Benutzername oder E-Mail
            <input type="text" v-model="username" id="user" required autofocus />
          </label>
          <label for="password">Passwort
            <input type="password" v-model="password" id="password" required />
          </label>
          <div class="login-bottom">
            <a href="/register" class="underline-hover">Kein Account? Hier registrieren</a>
            <button type="submit">Anmelden</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- <pre>auth:{{ auth }}</pre> -->
</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'
import { ofetch } from 'ofetch'
import { ref } from 'vue'

const username = ref('')
const password = ref('')
const auth = useAuth()
const API_URL = import.meta.env.VITE_API_URL

async function login() {
  console.log('login as ', username.value, password.value)
  await auth.login(username.value, password.value);
}

</script>