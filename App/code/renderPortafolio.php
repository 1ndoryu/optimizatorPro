<?php

use Glory\Components\ContentRender;
use Glory\Manager\OpcionManager;

function renderPortfolio()
{
    $paginacionActiva = OpcionManager::get('portafolio_paginacion_activa', true);
    $itemsPorPagina = (int) OpcionManager::get('portafolio_items_por_pagina', 3);
    $maximoItems = (int) OpcionManager::get('portafolio_maximo_items', -1);
    $orden = OpcionManager::get('portafolio_orden', 'date');

    $opcionesRender = [
        'plantillaCallback'    => 'portfolioItem',
        'orden'                => ($orden === 'rand') ? 'random' : 'fecha',
        'argumentosConsulta'   => [],
    ];

    if ($paginacionActiva) {
        $opcionesRender['paginacion'] = true;
        $opcionesRender['publicacionesPorPagina'] = $itemsPorPagina > 0 ? $itemsPorPagina : 3;
    } else {
        $opcionesRender['paginacion'] = false;
        $opcionesRender['publicacionesPorPagina'] = $maximoItems; // WP_Query interpreta -1 como 'sin límite'
    }

    ob_start();
    ContentRender::print('portfolio', $opcionesRender);

    $output = ob_get_clean();
    return $output;
}

add_shortcode('renderPortfolio', 'renderPortfolio');