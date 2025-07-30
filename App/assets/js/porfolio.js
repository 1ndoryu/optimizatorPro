/**
 * Script de animación inteligente para valores de portafolio.
 * Anima de 'BEFORE' a 'AFTER'.
 * - Si ambos valores son numéricos, anima el contador.
 * - Si no, realiza un efecto de fundido (cross-fade).
 */
function PortfolioW() {

    /**
     * Extrae el número, prefijo y sufijo de una cadena.
     * @param {string} str - La cadena a analizar (ej. "Top 5", "85%", "1,200").
     * @returns {object|null} - Un objeto con las partes o null si no hay número.
     */
    const extractParts = (str) => {
        const match = String(str).match(/([^\d.,]*)([\d.,]+)(.*)/);
        if (!match) return null;
        return {
            prefix: match[1],
            number: parseFloat(match[2].replace(/,/g, '')),
            suffix: match[3],
        };
    };

    /**
     * Inicia la animación para un elemento cuando es visible.
     * @param {HTMLElement} el - El elemento a animar.
     */
    const triggerAnimation = (el) => {
        const startStr = el.dataset.startValue;
        const finalStr = el.dataset.finalValue;

        const startParts = extractParts(startStr);
        const finalParts = extractParts(finalStr);

        // --- Decisión clave: Animar números o fundir texto ---
        if (startParts && finalParts) {
            // Caso 1: Ambos tienen números -> Animar contador
            animateCounter(el, startParts, finalParts, finalStr);
        } else {
            // Caso 2: Uno o ambos son texto -> Animar con fundido
            animateCrossFade(el, finalStr);
        }
    };

    /**
     * Anima un contador numérico de un valor inicial a uno final.
     */
    const animateCounter = (el, startParts, finalParts, finalStr, duration = 4000) => {
        const startNumber = startParts.number;
        const finalNumber = finalParts.number;
        let startTime = null;

        const animationStep = (timestamp) => {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / duration, 1);
            
            // Aplicar función de aceleración (ease-in cúbico) para empezar lento y acelerar
            const easedProgress = Math.pow(progress, 3);
            
            const currentNumber = Math.floor(easedProgress * (finalNumber - startNumber) + startNumber);
            
            el.textContent = finalParts.prefix + currentNumber.toLocaleString() + finalParts.suffix;

            if (progress < 1) {
                requestAnimationFrame(animationStep);
            } else {
                el.textContent = finalStr; // Asegurar valor final exacto
            }
        };
        requestAnimationFrame(animationStep);
    };

    /**
     * Anima un cambio de texto con un efecto de fundido (cross-fade).
     */
    const animateCrossFade = (el, finalStr, duration = 300) => {
        el.style.transition = `opacity ${duration}ms ease-in-out`;
        el.style.opacity = '0'; // Fundido de salida

        setTimeout(() => {
            el.textContent = finalStr; // Cambiar texto mientras es invisible
            el.style.opacity = '1'; // Fundido de entrada
        }, duration);
    };

    // --- Observer para disparar las animaciones ---
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                triggerAnimation(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2 // Activar cuando el 20% sea visible
    });

    document.querySelectorAll('.animated-value').forEach(el => observer.observe(el));
}

document.addEventListener('gloryRecarga', PortfolioW);
