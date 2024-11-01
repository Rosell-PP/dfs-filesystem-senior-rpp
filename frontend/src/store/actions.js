import api from "@/plugins/axios";

export default {
    /**
     * Registra un nuevo usuario en la base de datos de la App
     */
    registerUser({ commit }, payload) {
        commit("changeLoading", true);

        console.log("state => registerUser ", payload);

        api.post("/api/users/register", payload)
            .then(response => {
                console.info("Response from axios request");
                console.info(response.data);
                commit('register', true);

                commit("changeLoading", false);
            })
            .catch(error => {
                console.error("Error in axios request");
                const errors = error.response.data.errors
                Object.entries(errors).forEach(([k,v]) => {
                    console.log(k);
                    v.forEach(value =>{
                        console.log(value);
                    })
                })


                commit("setValidationErrors", errors);
                commit("changeLoading", false);
            });
    },

    /**
     * Modifica el estado de registered a false
     */
    unregister({commit}) {
        commit('register', false);
    },

    /**
     * Autentica el usuario contra el api
     */
    authenticateUser({ commit }, payload) {
        console.log("state => authenticateUser");

        api.post("/api/users/login", payload)
            .then(response => {
                console.info("Response from axios request");
                const user = response.data.user;

                // Guarda la información del usuario en localStorage
                localStorage.setItem('user', JSON.stringify(user));

                commit("login", user);
            })
            .catch(error => {
                console.error("Error in axios request");
                console.error(error.response.data.errors);
            });
    },
    
    /**
     * Cierra la sesión del usuario autenticado
     */
    logoutUser({ commit }, router) {
        console.log("state => logoutUser");
        const user = JSON.parse(localStorage.getItem('user'));

        api.post("/api/users/logout", {}, {
            headers: {
                Authorization: `Bearer ${user.token}`
            }
        })
            .then(response => {
                commit('logout');

                // Elimina la información del usuario en localStorage  
                localStorage.removeItem('user');
                
                router.push({ name: 'Home' }); // Redirigir al Home
            })
            .catch(error => {
                console.error("Error in axios request");
                console.error(error.response.data.errors);
            });
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
}
