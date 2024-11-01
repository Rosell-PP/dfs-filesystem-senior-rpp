export default {
    order: "0",
    rail: false,

    user: null,
    isAuthenticated: false,

    registered:false,       // Si se ha registrado el usuario correctamente

    loading: false,

    // Reglas de validación
    validationRules: {
        required: (v) => !!v || "This information is mandatory",

        email: (v) =>
            /^[\w.-]+@[a-zA-Z]+\.[a-zA-Z]{2,6}$/
            .test(v) || !v || "Incorrect email address format",

        password: (v) =>
            /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/
            .test(v) || !v || "Your password must contain at least 8 characters, including numbers, lowercase, uppercase, and special characters",
    },

    // Los errores obtenidos del api en la validación de formularios
    validationErrors: {}
}
