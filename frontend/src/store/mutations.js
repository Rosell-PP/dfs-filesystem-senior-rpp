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
}
