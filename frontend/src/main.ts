import './assets/main.css'
import './assets/normalize.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { ofetch } from "ofetch";

const app = createApp(App)

app.use(router)

app.mount('#app')
