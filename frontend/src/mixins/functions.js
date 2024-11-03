/**
 * Mixin para reutilizar funcionalidades en la App
 */

export default {
    /**
     * Funciones que se reutilizan
     */
    methods: {
        /**
         * Devuelve si hay errores de validación en determinado campo
         */
        hasValidationErrors(field) {
            const errors = this.validationErrors();
            if (Object.hasOwn(errors, field)) {
                return errors[field];
            }
            
            return null;
        },
    }
}