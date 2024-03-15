<template>
  <header>
    <RouterLink to="/" class="header__left">
      <img src="/src/assets/logo.svg" alt="logo" class="logo" />
      <h3>Umfrage Portal</h3>
    </RouterLink>

    <div class="header__right" v-if="auth.session.user">
      <nav>
        <ul>
          <li>
            <RouterLink to="/">Home</RouterLink>
          </li>
          <li>
            <RouterLink to="/survey/list">Umfragen</RouterLink>
          </li>
        </ul>
      </nav>
      <span>{{ auth.session.user.username }}</span>
      <span v-if="auth.session.user.role">({{ auth.session.user.role }})</span>
      <span @click="auth.logout">Logout</span>
      <Avatar
        imageUrl="https://unchainedcrypto.com/wp-content/uploads/2023/07/pfp-nft.png"
        class="header__avatar"
      ></Avatar>
    </div>

    <div class="header__right" v-else>
      <nav>
        <ul>
          <li>
            <RouterLink to="/login">Login</RouterLink>
          </li>
          <li>
            <RouterLink to="/register">Registrieren</RouterLink>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'

const auth = useAuth()
</script>

<style>
header {
  display: flex;
  justify-content: space-between;
  border-bottom: 2px solid var(--border);
  padding: 5px 40px;
}

.header__left {
  display: flex;
  align-items: center;
  /* no link styling */
  text-decoration: none;
  color: black;
  font-weight: bold;
  font-size: 1.5rem;
}

.header__left img {
  height: 40px;
  width: auto;
}

.header__right ul {
  padding: 0;
  list-style: none;
  display: flex;
}

.header__right {
  display: flex;
  align-items: center;
}

#app .header__avatar {
  height: 40px;
  width: 40px;
  border: 1px solid black;
}

.header__right a {
  color: black;
  text-decoration: none;
  padding: 0 15px;
  transition: all 0.3s;
}

.header__right a:hover {
  opacity: 0.7;
}
</style>
