<template>
  <div class="login-container">
    <div class="login-content">
        <div class="login-header">
            <div class="login-header_left">
                <img src="/src/assets/logo.svg" alt="logo">
                <span class="app-name">Umfrage Portal</span>
            </div>
        </div>
        <div class="login-body">
        <h2>Login</h2>
        <form method="post" id="login">
            <label for="user">Benutzername oder E-Mail
            <input type="text" name="user" id="user" required autofocus>
            </label>
            <label for="password">Passwort
            <input type="password" name="password" id="password" required>
            </label>
            <div class="login-bottom">
                <a href="" class="underline-hover">Kein Account? Hier registrieren</a>
                <button @click="auth.login">Anmelden</button>
            </div>
        </form>
        </div>
    </div>
  </div>
  <pre>auth:{{ auth }}</pre>
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

<style>
.login-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 50vh
}

.login-content {
  border-radius: 10px;
  background-color: var(--secondary);
  box-shadow: 0 0 12px 0px #0000002b;
  padding: 30px;
  border: 1px solid #cbcbcb;
  width: 70vw;
  max-width: 500px
}

.login-header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  flex-wrap: wrap
}

.login-header_left {
  display: flex;
  align-items: center
}

.login-header_left .app-name {
  font-size: 20px;
  font-weight: 600;
  padding-bottom: 5px
}

.login-header img {
  width: 60px;
  height: auto
}

h2 {
  font-size: 24px
}

label {
  user-select: none;
  display: grid;
  padding: 5px 0
}

input[type="text"],input[type="email"],input[type="password"] {
  outline: none;
  border: 1px solid #c9c9c9;
  border-radius: 10px;
  padding: 12px;
  background: var(--background);
  transition: border 0.2s;
}

input[type="text"]:focus,input[type="email"]:focus,input[type="password"]:focus {
  border: 1px solid #7e7e7e
}

.underline-hover{
  color: rgb(0, 0, 0);
  text-decoration: none;
}

.login-bottom {
  display: flex;
  justify-content: space-between
}

button {
  outline: none;
  border: none;
  background: rgb(231, 231, 231);
  padding: 6px 12px;
  border-radius: 17px;
  margin-top: 15px;
  transition: background-color 0.3s,transform 0.2s;
  font-size: 13px
}

button:hover:not(:disabled) {
  background-color: rgb(204, 204, 204);
  transform: scale(1.05);
  cursor: pointer
}

button:disabled {
  opacity: 0.6
}

a {
  font-size: 12px;
  height: fit-content
}
</style>