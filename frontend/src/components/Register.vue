<template>  
    <v-container>  
      <h1>Register</h1>
      <div v-if="registered() === false">
        <v-form @submit.prevent="register" >
          <v-text-field label="Username" v-model="form.username"></v-text-field>  
          <v-text-field label="Email" v-model="form.email"></v-text-field>  
          <v-text-field label="Password" type="password" v-model="form.password"></v-text-field>  
          <v-text-field label="Password Confirmation" type="password" v-model="form.password_confirmation"></v-text-field>
          
          <v-btn type="submit">Register</v-btn>  
        </v-form>
      </div>

      <div v-else>
        <v-alert
          text="You have been registered successfully"
          title="Registration Done"
          close-label="Close"
          closable
          type="success"
          @click:close="unregister"
        ></v-alert>
      </div>
    </v-container>  
  </template>  
  
  <script>  
  import { mapActions, mapGetters } from 'vuex';
  
  export default {  
    data() {  
      return {
        form:{
          username: 'username',
          email: 'email@gmail.com',
          password: '1Qaz2wsx*-+',
          password_confirmation: '1Qaz2wsx*-+',
        }  
      };  
    },  
    methods: {  
      ...mapActions(['registerUser', 'unregister']),
      ...mapGetters(['registered']),
      
      register() {  
        const payload = {
            username: this.form.username,
            email:    this.form.email,
            password: this.form.password,
            password_confirmation: this.form.password_confirmation,
        }

        this.registerUser(payload);
      },  
    },  
  };  
  </script>