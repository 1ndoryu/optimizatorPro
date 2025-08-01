<?php

use Glory\Manager\OpcionManager;

OpcionManager::register('portafolio_paginacion_activa', [
    'valorDefault'    => true,
    'tipo'            => 'checkbox',
    'etiqueta'        => 'Enable Pagination',
    'descripcion'     => 'Check this box to enable pagination for the portfolio. If unchecked, all items (up to the maximum limit) will be displayed on one page.',
    'seccion'         => 'portafolio',
    'etiquetaSeccion' => 'Portfolio',
    'subSeccion'      => 'Portfolio',
]);

OpcionManager::register('portafolio_items_por_pagina', [
    'valorDefault'    => 3,
    'tipo'            => 'numero',
    'etiqueta'        => 'Items per Page',
    'descripcion'     => 'Define how many projects are shown per page. This only applies if pagination is enabled.',
    'seccion'         => 'portafolio',
    'etiquetaSeccion' => 'Portfolio',
    'subSeccion'      => 'Portfolio',
]);

OpcionManager::register('portafolio_maximo_items', [
    'valorDefault'    => -1,
    'tipo'            => 'numero',
    'etiqueta'        => 'Total Maximum Items',
    'descripcion'     => 'Defines the total maximum number of projects to display when pagination is disabled. Use -1 to show all projects.',
    'seccion'         => 'portafolio',
    'subSeccion'      => 'Portfolio',
]);

OpcionManager::register('portafolio_orden', [
    'valorDefault' => 'date',
    'tipo'         => 'select',
    'etiqueta'     => 'Item Order',
    'descripcion'  => 'Choose the order in which the projects will be displayed.',
    'opciones'     => [
        'date' => 'Publication date (most recent first)',
        'rand' => 'Random',
    ],
    'seccion'      => 'portafolio',
    'subSeccion'   => 'Portfolio',
]);


OpcionManager::register('home_blur_effect_enabled', [
    'valorDefault' => '1',
    'tipo'         => 'checkbox',
    'etiqueta' => 'Enable Blur Effect on Home',
    'descripcion' => 'Activate or deactivate the blur circles on the homepage.',
    'seccion' => 'Blur_color_background',
    'etiquetaSeccion' => 'Blur Color Background',
    'subSeccion' => 'Blur color background'
]);

OpcionManager::register('home_blur_opacity', [
    'valorDefault' => '0.5',
    'etiqueta' => 'Blur Opacity',
    'seccion' => 'Blur_color_background',
    'subSeccion' => 'Blur color background'
]);

OpcionManager::register('home_blur_amount', [
    'valorDefault' => '70',
    'etiqueta' => 'Amount of Blur (px)',
    'seccion' => 'Blur_color_background',
    'subSeccion' => 'Blur color background'
]);

OpcionManager::register('home_blur_circle1_top', [
    'valorDefault' => '20',
    'etiqueta' => 'Circle 1: Top Position (%)',
    'seccion' => 'Blur_color_background',
    'subSeccion' => 'Blur color background'
]);

OpcionManager::register('home_blur_circle1_left', [
    'valorDefault' => '60',
    'etiqueta' => 'Circle 1: Left Position (%)',
    'seccion' => 'Blur_color_background',
    'subSeccion' => 'Blur color background'
]);

OpcionManager::register('home_blur_circle2_top', [
    'valorDefault' => '25',
    'etiqueta' => 'Circle 2: Top Position (%)',
    'seccion' => 'Blur_color_background',
    'subSeccion' => 'Blur color background'
]);

OpcionManager::register('home_blur_circle2_left', [
    'valorDefault' => '50',
    'etiqueta' => 'Circle 2: Left Position (%)',
    'seccion' => 'Blur_color_background',
    'subSeccion' => 'Blur color background'
]);