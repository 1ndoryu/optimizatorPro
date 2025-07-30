<?php

/**
 * Registra el shortcode para animar palabras (versión actualizada).
 * Permite definir las palabras como atributo o como contenido del shortcode.
 *
 * @param array $atributos Atributos del shortcode.
 * @param string $contenido Contenido entre las etiquetas del shortcode.
 * @return string HTML y script de la animación.
 */
function animateText($atributos, $contenido = null)
{
    $valoresPorDefecto = shortcode_atts([
        'palabras' => '',
        'tiempo'   => 2000
    ], $atributos);

    $fuenteDePalabras = '';

    if (!empty($valoresPorDefecto['palabras'])) {
        $fuenteDePalabras = $valoresPorDefecto['palabras'];
    } elseif (!empty($contenido)) {
        $fuenteDePalabras = $contenido;
    } else {
        $fuenteDePalabras = 'diseño,desarrollo,creatividad';
    }

    $listaPalabras = array_map('trim', explode(',', sanitize_text_field($fuenteDePalabras)));
    $tiempoEspera = intval($valoresPorDefecto['tiempo']);
    $idUnico = 'contenedor-animado-' . uniqid();


    $html = '<span id="' . esc_attr($idUnico) . '" class="palabras-animadas-cursor"></span>';

    $datosParaScript = [
        'idElemento'   => '#' . $idUnico,
        'palabras'     => $listaPalabras,
        'tiempoEspera' => $tiempoEspera
    ];

    $scriptDeInicio = '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof animarPalabras === "function") {
                animarPalabras(' . json_encode($datosParaScript) . ');
            }
        });
    </script>';

    return $html . $scriptDeInicio;
}

add_shortcode('animateText', 'animateText');
