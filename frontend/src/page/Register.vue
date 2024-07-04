<template>
  <form @submit.prevent="onSumit">
    <h1>Registrieren</h1>
    <div id="errors">
      <span v-for="(error, index) in errors" :key="index">{{ error }}</span>
    </div>
    <label for="username">Username</label>
    <input type="text" v-model="username" placeholder="Username" />
    <label for="mail">E-Mail</label>
    <input type="email" v-model="mail" placeholder="E-Mail" />
    <label for="password">Password</label>
    <input type="password" v-model="password" placeholder="Password" />
    <button type="submit">Account erstellen</button>
  </form>
</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'
import {ref} from "vue";
import {FetchError} from "ofetch";

const auth = useAuth();

const username = ref('');
const mail = ref('');
const password = ref('');
const errors = ref<string[]>([]);

const onSumit = async () => {
  console.log(username, mail, password);
  if (!username.value || !mail.value || !password.value) {
    errors.value = ['Bitte füllen Sie alle Felder aus'];
    return;
  }
  errors.value = [];
  try {
    const regError = await auth.register(username.value, mail.value, password.value);
    console.log(regError);
    if (regError) {
      errors.value.push(regError || 'Unbekannter Fehler');
    }
  }
  catch (e) {
    const error = e as Error;
    console.error(e);
    errors.value.push(error.message);
  }
}
</script>
