<template>
  <div>
    <from>
      <h1>Login</h1>
      <label for="username">Username</label>
      <input type="text" placeholder="Username" />
      <label for="password">Password</label>
      <input type="password" placeholder="Password" />
      <button @click="login">Login</button>
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

const login = async () => {
  const response = await fetch(API_URL + '/login', {
    mode: 'no-cors',
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      username: username.value,
      password: password.value
    })
  })

  if (response.ok) {
    const data = await response.json()
    console.log(data)
    // Handle the response data here
  } else {
    // Handle the error case here
  }
}
</script>
