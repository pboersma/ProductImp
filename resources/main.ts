import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios';

import App from './App.vue'

// Vuetify
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})

import './assets/main.css'

declare global {
    interface Window {
        ProductImp: any;
    }
}

// Set Axios Defaults.
if(import.meta.env.PROD) {
    axios.defaults.baseURL = window.ProductImp.root;
    axios.defaults.headers.common['X-WP-Nonce'] = window.ProductImp.nonce;
} else {
    axios.defaults.baseURL = 'https://boersma.dev/wp-json';
    axios.defaults.headers.common['Authorization'] = 'Basic cC5ib2Vyc21hQGx5Y2FuLW1lZGlhLm5sOmZ1Vmsgbm5oZyBpRWZ2IDV2RjMgVWdPTiBBVE5C'
}


const app = createApp(App)

app.use(createPinia()).use(vuetify)

app.mount('#app')
