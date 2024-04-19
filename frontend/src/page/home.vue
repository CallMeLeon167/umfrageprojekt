<template>
  <div class="home__wrapper">
    <div class="home__left">
      <h2>Letzte Umfrage</h2>
      <div class="last-survey">
        <h3>Umfrage Title</h3>
        <p>Das ist die letzte Umfrage</p>
      </div>
    </div>
    <div class="home__right">
      <h2>Top Voters</h2>
      <div class="top-voters">
        <div class="top-voter" v-for="voter in topVoters" :key="voter.id">
          <div class="voter-content">
            <Avatar imageUrl="https://i0.wp.com/pbs.twimg.com/media/FtsxswzaUAAZXJj.jpg:large?ssl=1" class="voter-img">
            </Avatar>
            <div class="voter-info">
              <h4>{{ voter.username }}</h4>
              <span>{{ voter.email }}</span>
            </div>
          </div>
          <span>{{ voter.votes }} Votes</span>
        </div>
      </div>
    </div>
    <div class="home__down">
      <h2>Alle Umfrage</h2>
      <div class="surveys_wrapper">
        <h3>Umfrage Title</h3>
        <p>irgendein content der umfrage</p>
      </div>
      <pre>res:{{ res }}</pre>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ofetch } from 'ofetch'
import { ref, onMounted } from 'vue'
import { type User } from '../types/auth';
const API_URL = import.meta.env.VITE_API_URL

const topVoters = ref<User[]>([])
const res = ref()

onMounted(async () => {
  const response = await fetch(API_URL + '/stats')
  const data = await response.json()
  topVoters.value = data[0].map((result: any, index: number) => ({
    id: index.toString(),
    username: result.a_username,
    email: result.a_emailaddress,
    votes: result.votes,
  }));
  res.value = await ofetch(API_URL + '/stats')
})
</script>

<style scoped>
.home__wrapper {
  display: flex;
  flex-wrap: wrap;
}

.home__left {
  width: 70%;
}

.home__right {
  width: 30%;
}

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

#app .voter-img {
  height: 60px;
  width: 60px;
}

.top-voter {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.top-voters {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.voter-content {
  display: flex;
  align-items: center;
  gap: 10px;
}

.voter-info {
  display: flex;
  flex-direction: column;
}

.voter-info h4 {
  margin: 0;
}

.voter-info span {
  font-size: 0.8rem;
}

@media (max-width: 768px) {

  .home__left,
  .home__right {
    width: 100%;
  }

  .last-survey {
    margin: 0;
  }
}
</style>
