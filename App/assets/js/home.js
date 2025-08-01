function HomeW() {
    const blobs = document.querySelectorAll('.blob');

    const settings = window.homeBlurSettings || {};

    // --- PARÁMETROS DINÁMICOS DE LA ANIMACIÓN ---
    const finalOpacity = parseFloat(settings.opacity ?? 0.5);
    const blurAmount   = parseInt(settings.blur ?? 70, 10);
    const enabled      = (settings.enabled ?? '1') === '1';
    const posValues    = {
        c1_top:  settings.c1_top  ?? 20,
        c1_left: settings.c1_left ?? 60,
        c2_top:  settings.c2_top  ?? 25,
        c2_left: settings.c2_left ?? 50,
    };

    // Si el efecto está desactivado ocultamos los blobs y salimos.
    if (!enabled) {
        blobs.forEach(b => b.style.display = 'none');
        return;
    }

    // Aplicar estilos iniciales según configuración
    blobs.forEach((blob, idx) => {
        blob.style.setProperty('filter', `blur(${blurAmount}px)`, 'important');
        if (idx === 0) {
            blob.style.setProperty('top',  `${posValues.c1_top}%`,  'important');
            blob.style.setProperty('left', `${posValues.c1_left}%`, 'important');
        } else {
            blob.style.setProperty('top',  `${posValues.c2_top}%`,  'important');
            blob.style.setProperty('left', `${posValues.c2_left}%`, 'important');
        }
    });

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

document.addEventListener('DOMContentLoaded', HomeW);
document.addEventListener('gloryRecarga', HomeW);

