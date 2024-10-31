<template>  
    <v-container>  
      <h1>Login</h1>  
      <v-form @submit.prevent="login">  
        <v-text-field label="Email" v-model="email"></v-text-field>  
        <v-text-field label="Password" type="password" v-model="password"></v-text-field>  
        <v-btn type="submit">Log In</v-btn>  
      </v-form>  
    </v-container>  
  </template>  
  
  <script>  
  import { mapActions } from 'vuex';  
  
  export default {  
    data() {  
      return {  
        email: '',  
        password: '',  
      };  
    },  
    methods: {  
      ...mapActions(['authenticateUser']),
      
      login() {  
        const user = { email: this.email }; // Simulación de login  
        this.authenticateUser(user); // Autenticación usando Vuex  
        this.$router.push({ name: 'Dashboard' }); // Redirigir al Dashboard  
      },  
    },  
  };  
  </script>