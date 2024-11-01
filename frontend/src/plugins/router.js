// src/router/index.js  
import { createRouter, createWebHistory } from 'vue-router';  
import store from '@/store';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';
import Home from '@/components/Home.vue';
import Files from '@/components/Files.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
  },
  {
    path: '/files',
    name: 'Files',
    component: Files,
    meta: { requiresAuth: true }, // Esta ruta requiere autenticación  
  },
];

const router = createRouter({  
  history: createWebHistory(), // Para usar el modo history  
  routes,  
});  

// Middleware de navegación para proteger rutas
router.beforeEach((to, from, next) => {
  // Primero limpio los errores de validación
  store.commit('setValidationErrors', {});

  // Luego verifico que el usuario este autenticado
  const isAuthenticated = !!localStorage.getItem('user'); // Verifica si hay un usuario autenticado

  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
      next({ name: 'Login' }); // Redirige a Login si no está autenticado
  } else {
      next(); // Permite la navegación
  }
});

export default router;