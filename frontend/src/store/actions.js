export default {
    /**
     * Autentica el usuario contra el api
     */
    authenticateUser({ commit }, user) {
        console.log("state => authenticateUser");

        // Aquí puedes hacer una llamada a tu API para autenticar al usuario  
        // Si la autenticación es exitosa:  
        commit('login', user);  
        // Guarda la información del usuario en localStorage si es necesario  
        localStorage.setItem('user', JSON.stringify(user));  
    },
    
    /**
     * Cierra la sesión del usuario autenticado
     */
    logoutUser({ commit }) {
        console.log("state => logoutUser");

        commit('logout');  
        // Elimina la información del usuario en localStorage  
        localStorage.removeItem('user');  
    },  

    /**
     * Restablece la sesión del usuario al cargar la app
     */
    restoreSession({ commit }) {
        console.log("state => restoreSession");

        const user = JSON.parse(localStorage.getItem('user'));  
        if (user) {  
            commit('login', user);  
        }  
    },

    /**
     * Registra un nuevo usuario en la base de datos de la App
     */
    registerUser({ commit }, payload) {
        console.log("state => registerUser ", payload);
    },
}
