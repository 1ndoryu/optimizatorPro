<?php

use Glory\Core\AssetManager;
use Glory\Manager\OpcionManager;
use Glory\Handler\FormHandler;
use Glory\Admin\SyncManager;

FormHandler::registerHandlerNamespace('App\\Code\\');

AssetManager::setGlobalDevMode(false);
AssetManager::setThemeVersion('0.1.6');
AssetManager::defineFolder('script', '/App/assets/js/');
AssetManager::defineFolder('style', '/App/assets/css/');
SyncManager::setAdminBarVisible(true);
SyncManager::setResetButtonVisible(false);

add_action('wp_enqueue_scripts', function() {
    if (is_front_page()) {
        $blur_settings = [
            'enabled' => OpcionManager::get('home_blur_effect_enabled', '1'),
            'opacity' => OpcionManager::get('home_blur_opacity', '0.5'),
            'blur'    => OpcionManager::get('home_blur_amount', '70'),
            'c1_top'  => OpcionManager::get('home_blur_circle1_top', '20'),
            'c1_left' => OpcionManager::get('home_blur_circle1_left', '60'),
            'c2_top'  => OpcionManager::get('home_blur_circle2_top', '25'),
            'c2_left' => OpcionManager::get('home_blur_circle2_left', '50'),
        ];

        wp_localize_script('home', 'homeBlurSettings', $blur_settings);
    }
}, 25);