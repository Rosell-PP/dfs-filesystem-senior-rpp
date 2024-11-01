export default {
    /**
     * Devuelve si el drawer está abierto o no
     */
    rail: state => {
        return state.rail;
    },

    /**
     * Devuelve el usuario autenticado
     */
    user: state => {
        return state.user;
    },

    /**
     * Devuelve si el usuario se ha autenticado
     */
    isAuthenticated: state => {
        return state.isAuthenticated;
    },

    /**
     * Devuelve si se ha registrado un usuario
     */
    registered: state => {
        return state.registered;
    },

    /**
     * Devuelve las reglas de validación
     */
    validationRules: state => {
        return state.validationRules;
    },

    /**
     * Devuelve si se está haciendo alguna solicitud al api
     */
    loading: state => {
        return state.loading;
    },

    /**
     * Devuelve los errores en la validación del formulario que se está enviando
     */
    validationErrors: state => {
        return state.validationErrors;
    },

    /**
     * Devuelve los archivos del usuario
     */
    files: state => {
        return state.files;
    },
}
