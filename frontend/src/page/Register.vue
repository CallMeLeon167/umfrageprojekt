<template>
  <div>
    <form @submit.prevent="onSumit">
      <h1>Registrieren</h1>
      <label for="username">Username</label>
      <input type="text" v-model="username" placeholder="Username" />
      <label for="mail">E-Mail</label>
      <input type="email" v-model="mail" placeholder="E-Mail" />
      <label for="password">Password</label>
      <input type="password" v-model="password" placeholder="Password" />
      <button type="submit">Account erstellen</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'
import {ref} from "vue";

const auth = useAuth();

const username = ref('');
const mail = ref('');
const password = ref('');

const onSumit = () => {
  console.log(username, mail, password);
  auth.register(username.value, mail.value, password.value);
}
</script>
