export default {

    /**
     * Establece el valor del rail
     */
    setRail(state, payload) {
        state.rail = payload;
    },

    /**
     * Establece cuando un usuario se ha registrado
     */
    register(state, value=true) {
        state.registered = value;
    },

    /**
     * Establece cuando un usuario ha iniiado sesión
     */
    login(state, user) {
        state.user = user;
        state.isAuthenticated = true;
    },

    /**
     * Establece el estado para indicar que se ha cerrado sesión
     */
    logout(state) {
        state.user = null;
        state.isAuthenticated = false;
    },

    /**
     * Establece el loading cuando se realiza una solicitud
     */
    changeLoading(state, value) {
        state.loading = value;
    },

    /**
     * Establece los errores de validación del formulario
     */
    setValidationErrors(state, payload) {
        state.validationErrors = payload;
    },

    /**
     * Establece los archivos del usuario
     */
    setFiles(state, payload) {
        state.files = payload;
    },

    /**
     * Actualiza un archivo editado en la lista de archivos
     */
    updateFileName(state, file) {
        state.files.data.forEach(element => {
            if (element.id == file.id) {
                element.name = file.name;
            }
        });
    },

    /**
     * Actualiza los datos de un archivo
     */
    updateFile(state, file) {
        state.files.data.forEach(element => {
            if (element.id == file.id) {
                element.name = file.name;
                element.path = file.path;
                element.size = file.size;
                element.compressed = file.compressed;
                element.zipped_at = file.zipped_at;
            }
        });
    },

    newFile(state, file) {
        // Si se está mostrando la cantidad de los elementos por página
        if (state.files.data.length >= state.files.per_page) {
            state.files.data.pop();
        }

        state.files.data.splice(0, 0, file);
        state.files.total += 1;
    }
}
