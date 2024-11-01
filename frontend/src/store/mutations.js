export default {
    setOrder(state, payload) {
        state.order = payload;
    },

    setRail(state, payload) {
        state.rail = payload;
    },

    register(state, value=true) {
        console.log("mutation register => ", value );

        state.registered = value;
    },

    login(state, user) {
        console.log("mutation login");

        state.user = user;
        state.isAuthenticated = true;
    },

    logout(state) {
        console.log("mutation logout");

        state.user = null;
        state.isAuthenticated = false;
    },

    changeLoading(state, value) {
        state.loading = value;
    },

    setValidationErrors(state, payload) {
        console.log("mutate setValidationErrors", payload);
        
        state.validationErrors = payload;
    }
}
