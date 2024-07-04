<template>
  <div id="errors">
    <span v-for="(error, index) in errors" :key="index">{{ error }}</span>
  </div>

  <div class="login-container">
    <div class="login-content">
      <div class="login-header">
        <div class="login-header_left">
          <img src="/src/assets/logo.png" alt="logo" />
          <span class="app-name">Umfrage Portal</span>
        </div>
      </div>
      <div class="login-body">
        <h2>Registrieren</h2>
        <form @submit.prevent="onSumit">
          <label for="username">Username
            <input type="text" v-model="username" placeholder="Username" />
          </label>
          <label for="mail">E-Mail
            <input type="email" v-model="mail" placeholder="E-Mail" />
          </label>
          <label for="password">Passwort
            <input type="password" v-model="password" placeholder="Password" />
          </label>
          <div class="login-bottom">
            <a href="/login" class="underline-hover">Ich habe einen Account</a>
            <button type="submit">Account erstellen</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'
import { ref } from "vue";
import { FetchError } from "ofetch";

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
