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

          <!-- Columna zipped_at -->
          <template #[`item.zipped_at`]="{ item }">
            {{ formatDate(item.zipped_at) }}
          </template>
          <!-- / Columna zipped_at -->

          <!-- Columna created_at -->
          <template #[`item.created_at`]="{ item }">
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
            <!-- Funcionalidad para editar un archivo -->
            <v-btn
              class="mr-1"
              density="comfortable"
              icon="mdi-file-edit"
              color="warning"
              @click="selectFileForEdit(item)"
            ></v-btn>
            <!-- / Funcionalidad para editar un archivo -->

            <!-- Funcionalidad para descargar un archivo -->
            <v-btn
              density="comfortable"
              icon="mdi-file-download"
              color="info"
              :disabled="!canDownloaded(item)"
            ></v-btn>
            <!-- / Funcionalidad para descargar un archivo -->
          </template>
          <!-- / Columna acciones sobre cada elemento de la tabla -->

      </v-data-table-server>

    </v-card>
    <!-- / Listado de archivos del usuario  -->

    <!-- Modal para editar el archivo -->
    <v-dialog
      v-model="showEdit"
      max-width="480"
    >
      <v-form @submit.prevent="update" ref="updateFileForm">
        <v-card title="Editing File">

          <v-container>
            <div class="text-secondary px-5 py-2">
              <p>Name : {{ selectedFile.name }}</p>
              <p>Size : {{ getFileSize(selectedFile.size) }}</p>
              <p>Uploaded : {{ formatDate(selectedFile.created_at) }}</p>
              <p>Compressed : {{ formatDate(selectedFile.zipped_at) }}</p>
            </div>
            <!-- Nombre del archivo -->
            <v-text-field
                label="File name"
                v-model="filename"
                :rules="[
                  rules.required,
                ]"
                :class="{ 'v-input--error': hasValidationErrors('name') }"
                :error-messages="hasValidationErrors('name')"
              ></v-text-field>
              <!-- / Nombre del archivo -->
          </v-container>
              
          <v-card-actions>
            <v-spacer></v-spacer>
  
            <v-btn
              text="Cancel"
              variant="text"
              @click="showEdit = false"
            ></v-btn>

            <v-btn
              type="sumbit"
              text="Update"
              :loading="isLoading"
            ></v-btn>
  
          </v-card-actions>
        </v-card>
      </v-form>

    </v-dialog>
    <!-- / Modal para editar el archivo -->

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
            { title: "5",  value: 5 },
            { title: "10", value: 10 },
            { title: "20", value: 20 },
            { title: "50", value: 50 },
            { title: "Todos", value: -1 }
        ],

        search: null,

        headers: [
          { title: 'Name',       key: 'name'  },
          { title: 'Size',       key: 'size'  },
          { title: 'Uploaded',   key: 'created_at' },
          { title: 'Compressed', key: 'zipped_at'  },
          { title: 'Actions',    key: 'action', sortable: false },
        ],

        selectedFile:null,
        showEdit: false,
        filename:"",
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

      // Las reglas de validación
      rules() {
        return this.validationRules();
      },

      // Si se está ejecutando una solicitud
      isLoading() {
        return this.loading();
      },
    },

    watch: {
      isLoading(value) {
        if (!value) {
          if (this.showEdit == true) {
            this.showEdit = false;
          }
        }
      }
    },

    methods: {
      ...mapGetters(['user', 'files', 'loading', 'validationRules', 'validationErrors']),

      ...mapActions(['loadFiles', 'updateFileName']),

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
      },

      /**
       * Devuelve si se puede descargar o no un archivo
       */
      canDownloaded(file) {
        return file.zipped_at != null;
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

      /**
       * Valida el formulario para editar el nombre de un archivo y lanza la solicitud
       */
      async update() {
        const self = this;
        const validated = await self.$refs.updateFileForm.validate();

        // Validamos que el formulario esté correcto, sin errores de validación
        if (validated.valid) {
          const payload = {
            filename: self.filename,
            id: self.selectedFile.id,
            token: self.getUser.token,
          };
  
          self.updateFileName(payload);
        } else {
          console.error("Errores de validación en el formulario de login");
        }
      },

      /**
       * Selecciona un archivo para ser editado
       */
      selectFileForEdit(item) {
        this.selectedFile = item;
        this.filename = item.name;
        this.showEdit = true;
      },

    },
  };  
</script>

<style scoped>
  .v-input--error {
    color: red;
  }
</style>