<?php

use Glory\Core\AssetManager;

AssetManager::setGlobalDevMode(false);
AssetManager::setThemeVersion('0.1.3');
AssetManager::defineFolder('script', '/App/assets/js/');
AssetManager::defineFolder('style', '/App/assets/css/');

AssetManager::define(
    'style',
    'app-admin-styles',
    '/App/assets/css/admin.css',
    ['area' => 'admin']
);