<?php

use Glory\Components\ContentRender;

/**
 * Define el shortcode [renderPortfolio] para mostrar los items del portafolio.
 *
 * Esta función captura la salida de ContentRender y la devuelve como un string,
 * permitiendo que se use dentro del contenido de WordPress.
 *
 * @return string El HTML renderizado para el portafolio.
 */
function renderPortfolio()
{
    ob_start();
    ContentRender::print('portfolio', [
        'plantillaCallback' => 'portfolioItem',
        'publicacionesPorPagina' => 3,
        'paginacion' => true,
  
    ]);


    $output = ob_get_clean();
    return $output;
}

add_shortcode('renderPortfolio', 'renderPortfolio');
