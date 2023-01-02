import { createApp } from 'vue';
import App from './AppAdmin.vue';
import router from "./router_admin";

createApp(App).use(router).mount('#app-admin');
