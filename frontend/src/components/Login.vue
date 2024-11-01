<template>  
    <v-container>  

      <h1>Login</h1>

      <div v-if="!authenticated">
        <v-form @submit.prevent="login">
          <v-text-field label="Email" v-model="email"></v-text-field>
          <v-text-field label="Password" type="password" v-model="password"></v-text-field>
          <v-btn type="submit">Log In</v-btn>
        </v-form>
      </div>
      <div v-else>
        <v-alert
          text="You have already login"
          title="Login Successfully"
          type="success"
        ></v-alert>
      </div>
    </v-container>
  </template>
  
  <script>  
  import { mapActions, mapGetters } from 'vuex';
  
  export default {  
    data() {  
      return {  
        email:    'email@gmail.com',  
        password: '1Qaz2wsx*-+',  
      };  
    },
    
    computed:{
      authenticated() {
        return this.isAuthenticated();
      } 
    },

    methods: {  
      ...mapActions(['authenticateUser']),
      ...mapGetters(['isAuthenticated']),
      
      login() {  
        const user = {
          email: this.email,
          password: this.password
        };

        this.authenticateUser(user);
        // this.$router.push({ name: 'Dashboard' }); // Redirigir al Dashboard  
      },
    },
    watch:{
      authenticated(value) {
        // Si se ha autenticado redirijo al home
        if (value) {
          this.$router.push({ name: 'Home' }); // Redirigir al Home
        }
      }
    }

  };  
  </script>