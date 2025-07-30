/**
 * Función que anima una lista de palabras con efecto de máquina de escribir.
 * @param {object} config - Objeto de configuración con idElemento, palabras y tiempoEspera.
 */
function animarPalabras(config) {
    // Aseguramos un almacén global para las configuraciones
    window.__animarPalabrasConfigs = window.__animarPalabrasConfigs || new Map();
    if (config && config.idElemento) {
        window.__animarPalabrasConfigs.set(config.idElemento, config);
    }
    const { idElemento, palabras, tiempoEspera, retardoInicial = 0 } = config || {};
    const elemento = document.querySelector(idElemento);

    if (!elemento) {
        console.error('El elemento para la animación no fue encontrado:', idElemento);
        return;
    }

    let indicePalabra = 0;
    let indiceLetra = 0;
    let estaBorrando = false;
    const velocidadEscritura = 120;
    const velocidadBorrado = 60;

    function cicloDeAnimacion() {
        const palabraActual = palabras[indicePalabra];
        let textoMostrado = '';

        if (estaBorrando) {
            // Fase de borrado
            textoMostrado = palabraActual.substring(0, indiceLetra - 1);
            elemento.textContent = textoMostrado;
            indiceLetra--;

            if (textoMostrado === '') {
                estaBorrando = false;
                indicePalabra = (indicePalabra + 1) % palabras.length; 
                setTimeout(cicloDeAnimacion, velocidadEscritura);
            } else {
                setTimeout(cicloDeAnimacion, velocidadBorrado);
            }
        } else {
            // Fase de escritura
            textoMostrado = palabraActual.substring(0, indiceLetra + 1);
            elemento.textContent = textoMostrado;
            indiceLetra++;

            if (textoMostrado === palabraActual) {
                estaBorrando = true;
                setTimeout(cicloDeAnimacion, tiempoEspera); // Espera antes de empezar a borrar
            } else {
                setTimeout(cicloDeAnimacion, velocidadEscritura);
            }
        }
    }

    // Iniciar la animación con retardo opcional
    setTimeout(cicloDeAnimacion, retardoInicial);
}

// Eliminamos el listener directo y lo reemplazamos por uno que re-ejecute con config almacenada
// document.addEventListener('gloryRecarga', animarPalabras);
document.addEventListener('gloryRecarga', () => {
    if (window.__animarPalabrasConfigs) {
        window.__animarPalabrasConfigs.forEach(cfg => {
            // Reiniciamos la animación para cada configuración guardada
            animarPalabras(cfg);
        });
    }
});