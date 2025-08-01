<?php

use Glory\Manager\OpcionManager;

OpcionManager::register('home_blur_effect_enabled', [
    'valorDefault' => '1',
    'etiqueta' => 'Activar Efecto Blur en Home',
    'descripcion' => 'Activa o desactiva los círculos con desenfoque en la página de inicio.',
    'seccion' => 'home_settings',
    'etiquetaSeccion' => 'Home Settings'
]);

OpcionManager::register('home_blur_opacity', [
    'valorDefault' => '0.5',
    'etiqueta' => 'Opacidad del Blur',
    'seccion' => 'home_settings'
]);

OpcionManager::register('home_blur_amount', [
    'valorDefault' => '150',
    'etiqueta' => 'Cantidad de Desenfoque (px)',
    'seccion' => 'home_settings'
]);

OpcionManager::register('home_blur_circle1_top', [
    'valorDefault' => '-20',
    'etiqueta' => 'Círculo 1: Posición Superior (%)',
    'seccion' => 'home_settings'
]);

OpcionManager::register('home_blur_circle1_left', [
    'valorDefault' => '-20',
    'etiqueta' => 'Círculo 1: Posición Izquierda (%)',
    'seccion' => 'home_settings'
]);

OpcionManager::register('home_blur_circle2_top', [
    'valorDefault' => '40',
    'etiqueta' => 'Círculo 2: Posición Superior (%)',
    'seccion' => 'home_settings'
]);

OpcionManager::register('home_blur_circle2_left', [
    'valorDefault' => '70',
    'etiqueta' => 'Círculo 2: Posición Izquierda (%)',
    'seccion' => 'home_settings'
]);
