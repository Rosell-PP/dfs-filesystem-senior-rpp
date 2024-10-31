<template>
    <v-list-item>
        <RouterLink to="/" class="custom-link" :style="rail? 'padding-left:0px':''">
        <v-icon class="mdi mdi-home-account"></v-icon>
        <span v-show="!rail">
            Home
        </span>
        </RouterLink>
    </v-list-item>

    <v-list-item v-if="!isAuthenticated()">
        <RouterLink to="/register" class="custom-link" :style="rail? 'padding-left:0px':''">
            <v-icon class="mdi mdi-account-plus"></v-icon>
            <span v-show="!rail">
            Register
            </span>
        </RouterLink>  
    </v-list-item>

    <!-- Inicio de sesión si no está autenticado el usuario -->
    <v-list-item v-if="!isAuthenticated()">
        <RouterLink to="/login" class="custom-link" :style="rail? 'padding-left:0px':''">
        <v-icon class="mdi mdi-login"></v-icon>
            <span v-show="!rail">
            Login
            </span>
        </RouterLink>
    </v-list-item>
    <!-- / Inicio de sesión si no está autenticado el usuario -->

    <!-- Cierre de sesión si está autenticado el usuario -->
    <v-list-item v-if="isAuthenticated()">
        <a
            href="javascript:void(0)"
            class="custom-link"
            :style="rail? 'padding-left:0px':''"
            @click.prevent="logout"
        >
            <v-icon class="mdi mdi-logout"></v-icon>
            <span v-show="!rail">
            Logout
            </span>
        </a>
    </v-list-item>
    <!-- / Cierre de sesión si está autenticado el usuario -->

</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'Navigation',
        props: {
            rail: {
                type: Boolean,
                required: true,
            },
        },
        methods: {
            ...mapActions(['logoutUser']),
            ...mapGetters(['isAuthenticated']),

            logout() {
                console.log("Log out!!!");

                this.logoutUser();
            }
        }
    }
</script>
