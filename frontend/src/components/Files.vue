<template>  
    <v-container>  

      <h1>Files</h1>

    </v-container>
  </template>
  
<script>  
  import echo from '@/plugins/echo';
  import { mapGetters } from 'vuex';


  export default {
    data() {  
      return {  
        
      };  
    },

    mounted() {
      const channel = `compress-files-channel-${this.getUser.id}`;
      console.log("Channel => ", channel);
      
      echo.channel(channel)
        .listen('.file.zipped', (e) => {
          console.log('Evento recibido:', e);
        });
    },

    computed:  {
      getUser() {
        return this.user();
      }
    },

    methods: {
      ...mapGetters(['user']),

    },
  };  
  </script>