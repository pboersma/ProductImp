import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios';

import App from './App.vue'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
import { aliases, mdi } from 'vuetify/iconsets/mdi'

const vuetify = createVuetify({
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        }
    },
    components,
    directives,
})

import './assets/main.css'

// Set Axios Defaults.
// axios.defaults.baseURL = 'https://boersma.dev/';
// axios.defaults.headers.common['Authorization'] = 'Basic cC5ib2Vyc21hQGx5Y2FuLW1lZGlhLm5sOmZ1Vmsgbm5oZyBpRWZ2IDV2RjMgVWdPTiBBVE5C'

declare global {
    interface Window {
        ProductImp: any;
    }
}

axios.defaults.baseURL = window.ProductImp.root;
axios.defaults.headers.common['X-WP-Nonce'] = window.ProductImp.nonce;

const app = createApp(App)

app.use(createPinia()).use(vuetify)

app.mount('#app')
