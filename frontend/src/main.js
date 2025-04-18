import './assets/main.css'
import 'boxicons'
import 'boxicons/css/boxicons.min.css';
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios';
import App from './App.vue'
import router from './router'

import { createNotivue } from 'notivue'
const notivue = createNotivue(/* Options */)
const app = createApp(App)
app.use(notivue)
axios.defaults.baseURL = 'http://localhost:8000/api'
axios.defaults.withCredentials = true

app.use(createPinia())
app.use(router)


app.mount('#app')
