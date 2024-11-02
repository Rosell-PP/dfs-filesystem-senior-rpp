export default {
    rail: false,    // Controla si se abre o cierra el drawer izquierdo

    user: null,     // Almacena los datos del usuario autenticado

    isAuthenticated: false, // Controla si se ha autenticado un usuario o no

    registered:false,       // Si se ha registrado el usuario correctamente

    loading: false,         // Si se está haciendo una solicitud al api

    files: [],  // Los archivos del usuario

    // Reglas de validación
    validationRules: {
        required: (v) => !!v || "This information is mandatory",

        // Para validar que se seleccione al menos 1 archivo
        file: (v) =>  (v && v.length > 0) || "This information is mandatory",

        email: (v) =>
            /^[\w.-]+@[a-zA-Z]+\.[a-zA-Z]{2,6}$/
            .test(v) || !v || "Incorrect email address format",

        password: (v) =>
            /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/
            .test(v) || !v || "Your password must contain at least 8 characters, including numbers, lowercase, uppercase, and special characters",
    },

    // Los errores obtenidos del api en la validación de formularios
    validationErrors: {},
}
