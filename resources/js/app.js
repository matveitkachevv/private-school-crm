// app.js
import './bootstrap';

import {createApp} from 'vue'
import App from './components/App.vue'
import Login from './components/auth/Login.vue'

import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import router from './router'
import store from './store/store'

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
    theme: {
        defaultTheme: store.state.theme
    }
})

createApp(App)
    .use(vuetify)
    .use(router)
    .use(store)
    .mount('#app')

createApp(Login)
    .use(vuetify)
    .use(router)
    .mount('#login')
