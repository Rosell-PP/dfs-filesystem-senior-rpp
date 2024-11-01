export default {
    rail: state => {
        return state.rail;
    },

    order: state => {
        return state.order;
    },

    user: state => {
        return state.user;
    },

    isAuthenticated: state => {
        return state.isAuthenticated;
    },

    registered: state => {
        return state.registered;
    },

    validationRules: state => {
        return state.validationRules;
    },

    loading: state => {
        return state.loading;
    },

    validationErrors: state => {
        return state.validationErrors;
    },
}
