import './bootstrap';
import { createApp } from 'vue';
import router from "./router";

import AppComponent from './src/App.vue';
createApp(AppComponent).use(router).mount("#app");