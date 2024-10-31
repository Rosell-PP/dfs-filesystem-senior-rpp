/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Components
import App from './App.vue'
import { registerPlugins } from '@/plugins'
import { createApp } from 'vue'; 
import { createVuetify } from 'vuetify';  
import 'vuetify/styles';  
import store from './store';            // Importa el store
import router from './plugins/router';  // Importa el router

const vuetify = createVuetify();

const app = createApp(App)  
  .use(vuetify) 
  .use(store) 
  .use(router) 
  .mount('#app');

  // Restablecer la sesión
store.dispatch('restoreSession');  