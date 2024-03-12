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
            <Avatar :imageUrl="voter.imageUrl" class="voter-img"></Avatar>
            <div class="voter-info">
              <h4>{{ voter.username }}</h4>
              <span>{{ voter.description }}</span>
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

const topVoters = ref([])
const res = ref()

onMounted(async () => {
  const response = await fetch('https://randomuser.me/api/?results=4')
  const data = await response.json()
  topVoters.value = data.results.map((result, index) => ({
    id: index,
    imageUrl: result.picture.large,
    username: result.login.username,
    description: result.email,
    votes: Math.floor(Math.random() * 100) + 1
  }))
  res.value = await ofetch('https://randomuser.me/api/?results=4')
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
