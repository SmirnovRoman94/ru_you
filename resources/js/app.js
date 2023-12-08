import './bootstrap';
import { createApp } from 'vue';
import router from "./router.js";
import { createPinia } from 'pinia'

const app = createApp({});

import IndexComponent from "./components/Index.vue";
app.component('index-component', IndexComponent);
const pinia = createPinia()
app.use(router)
app.use(pinia)
app.mount('#app');
