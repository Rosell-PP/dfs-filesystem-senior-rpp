<script setup>
    import { useDisplay } from 'vuetify/lib/framework.mjs';
    import { mapState, mapGetters, useStore } from 'vuex';
</script>

<template>
  <v-app class="bg-grey-lighten-4">

    <!-- Drawer izquierdo -->
    <v-navigation-drawer
            v-model="drawer"
            :rail="display.xs? true:rail"
            permanent
            color="blue-grey-lighten-3"
        >
            <v-list>
                <!-- Si el drawer está cerrado -->
                 <v-list-item v-if="rail">
                   <template v-slot:append >
                     <v-btn
                         icon="mdi-chevron-right"
                         variant="text"
                         @click.stop="toogleRail"
                     ></v-btn>
                   </template>
                  </v-list-item>
                <!-- / Si el drawer está cerrado -->

                <!-- Si el drawer está abierto -->
                <v-list-item v-else>
                    <template v-slot:append>
                        <span v-if="isAuthenticated" class="text-primary">
                            Hi {{ user.name }} <{{ user.email }}>
                        </span>
                        <v-btn
                            icon="mdi-chevron-left"
                            variant="text"
                            @click.stop="toogleRail"
                        ></v-btn>
                    </template>
                </v-list-item>
                <!-- / Si el drawer está abierto -->

            </v-list>

            <v-divider></v-divider>

            <Navigation :rail="rail"></Navigation>

            <v-divider></v-divider>

        </v-navigation-drawer>
        <!-- / Drawer izquierdo -->
      
    <v-main>
      <div class="container">
        <RouterView />
      </div>
    </v-main>

      <AppFooter />
  </v-app>
</template>

<script>

    export default {
        data() {
            return {
                drawer:  true,
                display: useDisplay(),
                store:   useStore(),
            }
        },

        computed: {
            ...mapState([
                'order',
                'rail',
                'user',
                'token',
                'isAuthenticated',
            ]),

            ...mapGetters([
                'order',
                'rail',
                'user',
                'token',
                'isAuthenticated',
            ]),
        },

        watch: {
          
        },

        mounted() {
        },

        methods: {
            toogleRail() {
                this.store.commit("setRail", !this.rail);
            },
        }
    }
</script>

<style>  
.custom-link {  
  display: block;
  text-decoration: none;    /* Elimina el subrayado */  
  color: #1e1ecd;          /* Cambia el color del texto */  
  padding: 20px;           /* Agrega padding */  
  border-radius: 5px;      /* Bordes redondeados */  
  transition: background-color 0.3s; /* Transición suave */  
}  

.custom-link:hover {  
  background-color: #e0e0e0; /* Color del fondo al pasar el mouse */  
}  
</style>  