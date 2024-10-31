// src/router/index.js  
import { createRouter, createWebHistory } from 'vue-router';  

import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';
import Home from '@/components/Home.vue';

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

//   {  
//     path: '/register',  
//     name: 'Register',  
//     component: Register,  
//     meta: { requiresAuth: true }, // Esta ruta requiere autenticación  
//   },  
];  

const router = createRouter({  
  history: createWebHistory(), // Para usar el modo history  
  routes,  
});  

// Middleware de navegación para proteger rutas  
router.beforeEach((to, from, next) => {  
  const isAuthenticated = !!localStorage.getItem('user'); // Verifica si hay un usuario autenticado  

    if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {  
        next({ name: 'Login' }); // Redirige a Login si no está autenticado  
    } else {  
        next(); // Permite la navegación  
    }  
});  

export default router;