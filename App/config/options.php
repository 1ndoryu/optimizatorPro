<?php

use Glory\Manager\OpcionManager;

OpcionManager::register('home_blur_effect_enabled', [
    'valorDefault' => '1',
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
