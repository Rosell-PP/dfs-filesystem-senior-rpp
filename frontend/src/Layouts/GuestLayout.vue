<script setup>
    /**
     * Plantilla para el usuario invitado
     *
     * @author rosellpp <rpupopolanco@gmail.com>
     * @copyright 2024 Ing. Rosell Pupo Polanco RoStack
     */
    import ApplicationLogo from '@/Components/ApplicationLogo.vue'
    import VuetifyLogo from '@/Components/VuetifyLogo.vue'
    import { useDisplay } from 'vuetify/lib/framework.mjs';

    const props = defineProps({
        auth: Object,
        copyright: String,
        appName: String,
    });
</script>

<script>
    export default {
        name: 'GuestLayout',

        data: function () {
            return {
                display: useDisplay(),
            }
        }
    }
</script>

<template>
    <!-- Slot para personalizar el título de la pagina -->
    <slot name="title"></slot>
    <!-- / Slot para personalizar el título de la pagina -->

    <v-app class="bg-grey-lighten-4">
        <!-- Vista principal -->
        <v-main>
            <v-parallax
                src="images/cat4.png"
                class="h-screen w-screen"
            >

                <v-row align="center" justify="center" style="height: 100vh">
                    <v-col cols="12" sm="12" md="10" lg="8">

                        <!-- Slot para personalizar el contenido de la página -->
                        <slot name="main"></slot>
                        <!-- / Slot para personalizar el contenido de la página -->

                    </v-col>
                </v-row>

            </v-parallax>
        </v-main>
        <!-- / Vista principal -->

        <!-- Footer -->
        <v-footer
            fixed
            padless
            color="primary"
        >
            <v-row
                justify="center"
                class="text-center align-center"
            >
                <!-- Laravel Logo SVG -->
                <v-col align="right">
                    <a target="_blank" href="https://laravel.com/">
                        <ApplicationLogo class="app-logo"></ApplicationLogo>
                    </a>
                </v-col>
                <!-- / Laravel Logo SVG -->

                <!-- App name y autor name -->
                <v-col>
                    <v-row class="text-blue-lighten-5 font-weight-bold">
                        <v-col cols="12" class="my-0 pb-0">
                            <span v-if="!display.xs">
                                {{ appName }}
                            </span>
                        </v-col>

                        <v-col cols="12" class="my-0 pt-0 align-center">
                            <div v-html="copyright"></div>
                        </v-col>
                    </v-row>
                </v-col>
                <!-- / App name y autor name -->

                <!-- Vuetify Logo SVG -->
                <v-col align="left">
                    <a target="_blank" href="https://vuetifyjs.com/">
                        <VuetifyLogo class="app-logo"></VuetifyLogo>
                    </a>
                </v-col>
                <!-- / Vuetify Logo SVG -->
            </v-row>
        </v-footer>
        <!-- / Footer -->

    </v-app>
</template>

<style>
    .app-logo {
       width: 50px !important;
       fill: azure;
    }
</style>
