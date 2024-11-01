<template>  
    <v-container>  

      <h1>Login</h1>

      <div v-if="!authenticated">
        <v-form @submit.prevent="login" ref="loginForm">

           <!-- Correo electrónico -->
           <v-text-field
            label="Email"
            v-model="email"
            :rules="[
              rules.required,
              rules.email,
            ]"
            :class="{ 'v-input--error': hasValidationErrors('email') }"
            :error-messages="hasValidationErrors('email')"
          ></v-text-field>
          <!-- / Correo electrónico -->

          <!-- Password -->
          <v-text-field
            label="Password"
            type="password"
            v-model="password"
            :rules="[
              rules.required,
              rules.password,
            ]"
            :class="{ 'v-input--error': hasValidationErrors('password') }"
            :error-messages="hasValidationErrors('password')"
          ></v-text-field>
          <!-- / Password -->

          <v-btn type="submit" :loading="isLoading">Log In</v-btn>
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
      // Devuelve si el usuario se ha autenticado
      authenticated() {
        return this.isAuthenticated();
      },

      // Las reglas de validación
      rules() {
        return this.validationRules();
      },

      // Si se está ejecutando una solicitud
      isLoading() {
        return this.loading();
      },
    },

    methods: {  
      ...mapActions(['authenticateUser']),
      ...mapGetters(['isAuthenticated', 'validationRules', 'loading', 'validationErrors']),
      
      /**
       * Valida el formulario de login y envía solicitud al api para iniciar sesión
       */
      async login() {
        const self = this;
        const validated = await self.$refs.loginForm.validate();

        // Validamos que el formulario esté correcto, sin errores de validación
        if (validated.valid) {
          const user = {
            email: self.email,
            password: self.password
          };
  
          self.authenticateUser(user);
        } else {
          console.error("Errores de validación en el formulario de login");
        }
      },

      /**
       * Devuelve si hay errores de validación en determinado campo
       */
      hasValidationErrors(field) {
        const errors = this.validationErrors();
        if (Object.hasOwn(errors, field)) {
          return errors[field];
        }
        return null;
      },
    },

    watch:{
      authenticated(value) {
        // Si se ha autenticado redirijo al home
        if (value) {
          this.$refs.loginForm.reset();
          this.$router.push({ name: 'Home' }); // Redirigir al Home
        }
      }
    }

  };  
  </script>

<style scoped>
  .v-input--error {
    color: red;
  }
</style>