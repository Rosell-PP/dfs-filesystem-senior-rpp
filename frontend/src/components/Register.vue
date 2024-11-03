<template>  
  <v-container>  

      <h1>Register</h1>

      <div v-if="registered() === false">
        <v-form @submit.prevent="register" ref="registerForm">
          <!-- Nombre de usuario -->
          <v-text-field
            label="Username"
            v-model="form.username"
            :rules="[
              rules.required
            ]"
            :class="{ 'v-input--error': hasValidationErrors('username') }"
            :error-messages="hasValidationErrors('username')"
          ></v-text-field>
          <!-- / Nombre de usuario -->

          <!-- Correo electrónico -->
          <v-text-field
            label="Email"
            v-model="form.email"
            :rules="[
              rules.required,
              rules.email,
            ]"
            :class="{ 'v-input--error': hasValidationErrors('email') }"
            :error-messages="hasValidationErrors('email')"
          ></v-text-field>
          <!-- / Correo electrónico -->

          <!-- Password y confirmación -->
          <v-text-field
            label="Password"
            type="password"
            v-model="form.password"
            :rules="[
              rules.required,
              rules.password,
            ]"
            :class="{ 'v-input--error': hasValidationErrors('password') }"
            :error-messages="hasValidationErrors('password')"
          ></v-text-field>

          <v-text-field
            label="Password Confirmation"
            type="password"
            v-model="form.password_confirmation"
            :rules="[
              rules.required,
              rules.password,
            ]"
          ></v-text-field>
          <!-- / Password y confirmación -->
          
          <v-btn type="submit" :loading="isLoading">Register</v-btn>

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
  import mymixin from '@/mixins/functions';
  import { mapActions, mapGetters } from 'vuex';
  
  export default {
    mixins:[
      mymixin
    ],

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

    computed:{
      // Las reglas de validación
      rules() {
        return this.validationRules();
      },

      // Si se está ejecutando una solicitud
      isLoading() {
        return this.loading();
      },

      /**
       * Si un usuario se ha registrado
       */
      areRegistered() {
        return this.registered();
      }
    },

    watch:{
      /**
       * Cuando un usuario se ha registrado resetea el formulario de registro
       */
      areRegistered(value) {
        if (value) {
          this.$refs.registerForm.reset();
        }
      }
    },

    methods: {  
      ...mapActions(['registerUser', 'unregister']),
      ...mapGetters(['registered', 'validationRules', 'loading', 'validationErrors']),
      
      /**
       * Valida el formulario de registro y envía solicitud al api para registrar el usuario
       */
      async register() {
        const self = this;
        const validated = await self.$refs.registerForm.validate();

        // Validamos que el formulario esté correcto, sin errores de validación
        if (validated.valid) {
          const payload = {
              username: self.form.username,
              email:    self.form.email,
              password: self.form.password,
              password_confirmation: self.form.password_confirmation,
          }
  
          self.registerUser(payload);
        } else {
          console.error("Errores de validación en el formulario de registro");
        }
      },
    },  
  };  
</script>


<style scoped>
  .v-input--error {
    color: red;
  }
</style>