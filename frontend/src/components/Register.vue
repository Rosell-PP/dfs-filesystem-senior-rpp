<template>  
    <v-container>  
      <h1>Register</h1>  
      <v-form @submit.prevent="register">  
        <v-text-field label="Username" v-model="username"></v-text-field>  
        <v-text-field label="Email" v-model="email"></v-text-field>  
        <v-text-field label="Password" type="password" v-model="password"></v-text-field>  
        <v-text-field label="Password Confirmation" type="password" v-model="password_confirmation"></v-text-field>
        
        <v-btn type="submit">Register</v-btn>  
      </v-form>  
    </v-container>  
  </template>  
  
  <script>  
  import { mapActions } from 'vuex';  
  
  export default {  
    data() {  
      return {  
        username: '',  
        email: '',  
        password: '',  
        password_confirmation: '',  
      };  
    },  
    methods: {  
      ...mapActions(['registerUser']),
      
      register() {  
        const payload = {
            username: this.username,
            email:    this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
        }

        this.registerUser(payload);
        // this.$router.push({ name: 'Dashboard' }); // Redirigir al Dashboard  
      },  
    },  
  };  
  </script>