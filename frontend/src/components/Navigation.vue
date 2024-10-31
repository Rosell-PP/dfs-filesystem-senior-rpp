<template>
    <v-list-item>
        <RouterLink to="/" class="custom-link" :style="rail? 'padding-left:0px':''">
        <v-icon class="mdi mdi-home-account"></v-icon>
        <span v-show="!rail">
            Home
        </span>
        </RouterLink>
    </v-list-item>

    <v-list-item>
        <RouterLink to="/register" class="custom-link" :style="rail? 'padding-left:0px':''">
            <v-icon class="mdi mdi-account-plus"></v-icon>
            <span v-show="!rail">
            Register
            </span>
        </RouterLink>  
    </v-list-item>

    <v-list-item>
        <RouterLink to="/login" class="custom-link" :style="rail? 'padding-left:0px':''">
        <v-icon class="mdi mdi-login"></v-icon>
            <span v-show="!rail">
            Login
            </span>
        </RouterLink>  
    </v-list-item>
</template>

<script>
    export default {
        name: 'Navigation',
        props: {
            rail: {
                type: Boolean,
                required: true,
            },
        },
    }
</script>
