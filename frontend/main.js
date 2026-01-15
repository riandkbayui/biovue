import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from '@/router'
import '@/style.css'
import '@fortawesome/fontawesome-free/css/all.min.css'
import '@mdi/font/css/materialdesignicons.min.css'
import 'boxicons/css/boxicons.min.css'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import App from '@/App.vue'

import { env } from '@/env'

const pinia = createPinia()
const app = createApp(App)

// Set default title
document.title = env.seo.baseTitle

app.use(pinia)
app.use(router)
app.mount('#app')
