jQuery(function($) {
    // Escuchamos el evento personalizado 'gloryRecarga' en el objeto window.
    // Este evento parece ser el que se dispara después de tu recarga AJAX.
    $(window).on('gloryRecarga', function() {

        console.log('Recarga AJAX detectada (gloryRecarga). Re-inicializando el formulario de Fusion.');

        // Usamos un pequeño retardo (setTimeout) para asegurarnos de que el nuevo
        // contenido del formulario ya esté completamente cargado en el DOM antes de intentar
        // adjuntar los eventos. 100 milisegundos es suficiente.
        setTimeout(function() {

            // Verificamos que el objeto y las funciones existan para evitar errores
            if (typeof window.fusionForms !== 'undefined' && typeof window.fusionForms.onReady === 'function') {

                // Volvemos a ejecutar las funciones de inicialización del formulario.
                // Esto adjuntará de nuevo los manejadores de eventos 'submit' y 'click'
                // al nuevo formulario que se cargó por AJAX.
                window.fusionForms.onLoad();
                window.fusionForms.onReady();

                // También re-inicializamos la lógica condicional del formulario si existe.
                if (typeof window.fusionForms.formLogics === 'function') {
                    window.fusionForms.formLogics();
                }

                 // También re-inicializamos los selectores personalizados si existen.
                 if (typeof addAvadaSelectStyles === 'function') {
                    addAvadaSelectStyles();
                 }
            }

        }, 100);
    });
});