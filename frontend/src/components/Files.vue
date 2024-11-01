<template>  
  <v-container>  

    <h1>Files</h1>

    <!-- Listado de archivos del usuario -->
    <v-card class="pa-4">

      <div class="d-flex flex-wrap align-center mb-5">
          <v-text-field
              v-model="search"
              label="Filter"
              variant="underlined"
              prepend-inner-icon="mdi-magnify"
              hide-details
              clearable
              single-line
          />

          <v-spacer />
          
      </div>

      <v-data-table-server
          :items="getFiles.data"
          :items-length="getFiles.total"
          :items-per-page-options="itemsPerPageOptions"
          items-per-page-text="Files per page"
          :headers="headers"
          :search="search"
          class="elevation-0"
          :loading="loading()"
          @update:options="loadItems"
      >

          <!-- Texto no-data personalizado -->
          <template v-slot:no-data>
              <p class="text-error font-weight-bold text-uppercase display-2">
                  No hay archivos registrados aún.
              </p>
          </template>
          <!-- / Texto no-data personalizado -->

          <!-- Columna zipped -->
          <template #[`item.zipped`]="{ item }">
            {{ formatDate(item.zipped_at) }}
          </template>
          <!-- / Columna zipped -->

          <!-- Columna created_at -->
          <template #[`item.created`]="{ item }">
            {{ formatDate(item.created_at) }}
          </template>
          <!-- / Columna created_at -->

          <!-- Columna size -->
          <template #[`item.size`]="{ item }">
            {{ getFileSize(item.size) }}
          </template>
          <!-- / Columna size -->

          <!-- Columna acciones sobre cada elemento de la tabla -->
          <template #[`item.action`]="{ item }">

          </template>
          <!-- / Columna acciones sobre cada elemento de la tabla -->

      </v-data-table-server>

      </v-card>
      <!-- / Listado de archivos del usuario  -->

  </v-container>
</template>
  
<script>  
  import echo from '@/plugins/echo';
  import { mapGetters, mapActions } from 'vuex';
  import moment from 'moment';
  import { filesize } from 'filesize';

  export default {
    data() {  
      return {  
        // Opciones a mostrar en los datatables
        itemsPerPageOptions: [
            { title: "10", value: 10 },
            { title: "20", value: 20 },
            { title: "50", value: 50 },
            { title: "Todos", value: -1 }
        ],

        search: null,

        headers: [
          { title: 'Name',       key: 'name'  },
          { title: 'Size',       key: 'size'  },
          { title: 'Uploaded',    key: 'created' },
          { title: 'Compressed', key: 'zipped'  },
          { title: 'Actions',    key: 'action', sortable: false },
        ],
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
      },

      getFiles() {
        return this.files();
      },
    },

    methods: {
      ...mapGetters(['user', 'files', 'loading']),

      ...mapActions(['loadFiles']),

      /**
       * Refresca el listado de archivos
       */
      loadItems(options) {
        console.log("Opciones => ", options);
        const { page, itemsPerPage, sortBy, sortDesc, search } = options;
        
        // Construcción de los parámetros de la solicitud
        const params = {  
          page,
          itemsPerPage,
          sortBy,
          sortDesc: sortDesc ? 'desc' : 'asc', // Asegúrate de que los valores se envíen adecuadamente
          search
        };

        // Cargamos los archivos del usuario
        this.loadFiles({user:this.getUser, params:params});
      },

      /**
       * Formato para las fechas
       *
       * @param  {DateTime} date      La fecha a convertir
       * @return {string}             La fecha formateada
       */
      formatDate(date) {
        if (!date) return '';
        return moment(date).format('DD-MM-YYYY HH:mm:ss');
      },

      /**
       * Devuelve el tamaño del archivo en formato legible
       */
      getFileSize(size) {
        return filesize(size)
      }
    },
  };  
  </script>