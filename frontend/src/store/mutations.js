export default {
    setOrder(state, payload) {
        state.order = payload;
    },

    setRail(state, payload) {
        state.rail = payload;
    },

    login(state, user, token) {
        state.user = user;
        state.token = token;
        state.isAuthenticated = true;
    },

    logout(state) {
        state.user = null;
        state.token = null;
        state.isAuthenticated = false;
    }
}
