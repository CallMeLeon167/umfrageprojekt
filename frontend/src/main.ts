import './assets/main.css'
import './assets/normalize.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Avatar from './components/Avatar.vue'

const app = createApp(App)

app.component('Avatar', Avatar)

app.use(router)

app.mount('#app')
