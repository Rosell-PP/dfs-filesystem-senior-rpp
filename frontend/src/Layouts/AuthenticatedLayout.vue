<script setup>
    /**
     * Plantilla para el usuario autenticado
     *
     * @author rosellpp <rpupopolanco@gmail.com>
     * @copyright 2024 Ing. Rosell Pupo Polanco RoStack
     */
    import { mapState, mapGetters, useStore } from 'vuex';
    import VuetifyLogo from '@/Components/VuetifyLogo.vue';
    import { useDisplay } from 'vuetify/lib/framework.mjs';
    import NavigationMenu from '@/Components/NavigationMenu.vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';

</script>

<template>
    <!-- Slot para personalizar el título de la pagina -->
    <slot name="title"></slot>
    <!-- / Slot para personalizar el título de la pagina -->

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
                <v-tooltip v-if="rail"
                    :text="`${$page.props.auth.user.name} <${$page.props.auth.user.email}>`"
                >
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            :prepend-avatar="$page.props.auth.user.image"
                            :title="$page.props.auth.user.name"
                            :subtitle="$page.props.auth.user.email"
                        ></v-list-item>
                    </template>
                </v-tooltip>
                <!-- / Si el drawer está cerrado -->

                <!-- Si el drawer está abierto -->
                <v-list-item v-else
                    :prepend-avatar="$page.props.auth.user.image"
                    :title="$page.props.auth.user.name"
                    :subtitle="$page.props.auth.user.email"
                >

                    <template v-slot:append>
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

            <!-- Resto de accesos para navegación -->
            <NavigationMenu :rail="rail"/>
            <!-- / Resto de accesos para navegación -->

        </v-navigation-drawer>
        <!-- / Drawer izquierdo -->

        <!-- Barra de navegación -->
        <v-app-bar color="primary"
            image="https://picsum.photos/1920/1080?random"
            :order="order"
        >
            <!-- Fondo de gradiente debajo de la barra de navegación -->
            <template v-slot:image>
                <v-img
                    gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"
                ></v-img>
            </template>
            <!-- / Fondo de gradiente debajo de la barra de navegación -->

            <!-- Switch para sobreponer la barra sobre el menú lateral o no -->
            <template v-slot:append>
                <v-switch
                    v-model="store.state.order"
                    false-value="0"
                    true-value="-1"
                    label="Todo el ancho"
                    hide-details
                    inset
                ></v-switch>
            </template>
            <!-- / Switch para sobreponer la barra sobre el menú lateral o no -->

            <v-app-bar-nav-icon v-if="$vuetify.display.mobile" @click.stop="drawer = !drawer" />
            <v-app-bar-nav-icon v-else @click.stop="toogleRail" />
            <v-toolbar-title :text="$page.props.appName" />
        </v-app-bar>
        <!-- / Barra de navegación -->

        <!-- Vista principal -->
        <v-main class="main">
            <v-container>
                <slot/>
            </v-container>
        </v-main>
        <!-- / Vista principal -->

        <!-- Footer -->
        <v-footer
            fixed
            color="secondary"
            class="dashboard-footer"
        >
            <template v-slot:image>
                <v-img
                    gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"
                ></v-img>
            </template>

            <v-row
                justify="center"
                class="text-center"
            >
                <!-- Laravel Logo SVG -->
                <v-col align="right" class="align-self-center">
                    <a target="_blank" href="https://laravel.com/">
                        <ApplicationLogo class="app-logo"></ApplicationLogo>
                    </a>
                </v-col>
                <!-- / Laravel Logo SVG -->

                <!-- App name y autor name -->
                <v-col class="align-self-center">
                    <v-row class="text-blue-lighten-5 font-weight-bold">
                        <v-col cols="12" class="my-0 pb-0">
                            <span v-if="!display.xs">
                                {{ $page.props.appName }}
                            </span>
                        </v-col>

                        <v-col cols="12" class="my-0 pt-0 align-center">
                            <div v-html="$page.props.copyright"></div>
                        </v-col>
                    </v-row>
                </v-col>
                <!-- / App name y autor name -->

                <!-- Vuetify Logo SVG -->
                <v-col align="left" class="align-self-center">
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

<script>
    import { useToast } from 'vue-toastification'

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
            ]),

            ...mapGetters([
                'order',
                'rail'
            ]),
        },

        watch: {
            $page: {
                handler() {
                    const toast = useToast();
                    const flash = this.$page.props.flash;

                    if (flash.success) {
                        toast.success(flash.success);
                    } else if (flash.error) {
                        toast.error(flash.error);
                    }
                },
            },

            // Observador sobre rail
            rail: (newValue, oldValue) => {
                console.log("Watching rail => " + newValue);
            },

            // Observador sobre order
            order: (newValue, oldValue) => {
                console.log("Watching order => " + newValue);
            }
        },

        mounted() {
            // this.drawer = !this.$vuetify.display.mobile;
        },

        methods: {
            toogleRail() {
                this.store.commit("setRail", !this.rail);
            },
        }
    }
</script>

<style>
    .app-logo {
       width: 50px !important;
       fill: #cccfe5 !important;
    }

    .main {
        height: 853px !important;
        overflow-y: scroll;
    }

    .dashboard-footer {
        background: linear-gradient(to right, rgba(19,84,122,.8), rgba(128,208,199,.8));
    }

</style>
