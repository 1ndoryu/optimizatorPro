<?php

use Glory\Core\AssetManager;
use Glory\Manager\OpcionManager;

AssetManager::setGlobalDevMode(true);
AssetManager::setThemeVersion('0.1.4');
AssetManager::defineFolder('script', '/App/assets/js/');
AssetManager::defineFolder('style', '/App/assets/css/');

AssetManager::define(
    'style',
    'app-admin-styles',
    '/App/assets/css/admin.css',
    ['area' => 'admin']
);

AssetManager::define(
    'script',
    'home-blur-editor',
    '/App/assets/js/HomeBlurEditor.js',
    [
        'deps'      => ['home'], // depende de home.js para disponer de homeBlurSettings
        'in_footer' => true,
    ]
);

add_action('wp_enqueue_scripts', function() {
    if (is_front_page()) {
        $blur_settings = [
            'enabled' => OpcionManager::get('home_blur_effect_enabled', '1'),
            'opacity' => OpcionManager::get('home_blur_opacity', '0.5'), // coincide con HomeW
            'blur'    => OpcionManager::get('home_blur_amount', '70'),   // blur.css: 70px
            'c1_top'  => OpcionManager::get('home_blur_circle1_top', '20'),  // top 20%
            'c1_left' => OpcionManager::get('home_blur_circle1_left', '60'), // left 60%
            'c2_top'  => OpcionManager::get('home_blur_circle2_top', '25'),  // top 25%
            'c2_left' => OpcionManager::get('home_blur_circle2_left', '50'), // left 50%
        ];

        // Registrar datos después que AssetManager haya registrado scripts (prioridad 20)
        wp_localize_script('home', 'homeBlurSettings', $blur_settings);
    }
}, 25);