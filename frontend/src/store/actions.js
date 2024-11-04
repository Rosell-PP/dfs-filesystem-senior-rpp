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
        commit("changeLoading", true);

        api.post("/api/users/login", payload)
            .then(response => {
                console.info("Response from axios request");
                const user = response.data.user;

                // Guarda la información del usuario en localStorage
                localStorage.setItem('user', JSON.stringify(user));

                commit("login", user);
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
     * Restablece la sesión del usuario al cargar la app desde el localStorage
     */
    restoreSession({ commit }) {
        console.log("state => restoreSession");

        const user = JSON.parse(localStorage.getItem('user'));

        if (user) {  
            commit('login', user);
        }  
    },

    /**
     * Carga los archivos del usuario
     */
    loadFiles({ commit }, payload) {
        commit("changeLoading", true);

        const user =  payload.user;
        const params =  payload.params;
        
        api.get(
            `/api/files`,
            {
                params:params,
                headers: {
                    Authorization: `Bearer ${user.token}`
                },
            })
            .then(response => {
                console.info("Response from axios request");
                console.info(response.data);

                commit('setFiles', response.data.files);
                commit("changeLoading", false);
            })
            .catch(error => {
                console.error("Error in axios request");
                console.error(error);
                commit("changeLoading", false);
            });
    },

    /**
     * Actualiza el nombre de un archivo
     */
    updateFileName({ commit }, payload) {
        commit("changeLoading", true);
        
        api.patch(
            `/api/files/update/${payload.id}`,
            {
                filename:payload.filename,
            },
            {
                headers: {
                    Authorization: `Bearer ${payload.token}`
                },
            })
            .then(response => {
                console.info("Response from axios request");
                console.info(response.data);
                
                commit("updateFileName", response.data.file);
                commit("changeLoading", false);
            })
            .catch(error => {
                console.error("Error in axios request");
                console.error(error);
                commit("changeLoading", false);
            });
    },

    /**
     * Sube un archivo a la App
     */
    uploadNewFile({ commit }, formData) {
        commit("changeLoading", true);
        
        api.post(
            `/api/files/upload`,
            formData,
            {
                headers: {
                    Authorization: `Bearer ${formData.get('token')}`,
                    'Content-Type': 'multipart/form-data',
                },
            })
            .then(response => {
                console.info("Response from axios request");
                console.info(response.data);

                commit("newFile", response.data.file);
                commit("changeLoading", false);
            })
            .catch(error => {
                console.error("Error in axios request");
                console.error(error);
                commit("changeLoading", false);
            });
    },

    /**
     * Ejecuta el commit para actualizar la info de un archivo
     * del listado
     */
    updateFile({commit}, file) {
        commit("updateFile", file);
    }
}
