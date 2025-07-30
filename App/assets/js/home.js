function HomeW() {
    const blobs = document.querySelectorAll('.blob');
    
    // --- PARÁMETROS DE LA ANIMACIÓN ---
    const finalOpacity = 0.5;
    const animationDuration = 2000; // 2 segundos, en milisegundos
    const fadeSpeed = 10;
    let scrollListenerActive = true;

    // --- 1. FUNCIÓN DE ANIMACIÓN MANUAL (APARICIÓN) ---
    let startTime = null;

    function animate(currentTime) {
        if (!startTime) {
            startTime = currentTime;
        }

        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / animationDuration, 1); // Progreso de 0 a 1

        const currentOpacity = progress * finalOpacity;
        blobs.forEach(blob => {
            blob.style.opacity = currentOpacity;
        });

        if (progress < 1) {
            // Si la animación no ha terminado, pide el siguiente cuadro
            requestAnimationFrame(animate);
        } else {
            // Animación terminada, ahora el scroll tiene control total.
            // Activamos un listener separado para el scroll.
            setupScrollListener();
        }
    }

    // Inicia la animación de aparición
    requestAnimationFrame(animate);


    // --- 2. FUNCIÓN PARA EL SCROLL (DESAPARICIÓN) ---
    function setupScrollListener() {
        window.addEventListener('scroll', () => {
            const scrollPercent = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight);
            const newOpacity = finalOpacity - (scrollPercent * finalOpacity * fadeSpeed);
    
            blobs.forEach(blob => {
                blob.style.opacity = Math.max(0, newOpacity);
            });
        });
    }
}


document.addEventListener('gloryRecarga', HomeW);

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