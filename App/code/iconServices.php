<?php

/**
 * Define los iconos de los servicios.
 */
add_action('init', function () {

    if (function_exists('iconos')) {
        iconos();
    }

    add_shortcode('servicio1', function () {
        return isset($GLOBALS['servicio1']) ? $GLOBALS['servicio1'] : '';
    });
    add_shortcode('servicio2', function () {
        return isset($GLOBALS['servicio2']) ? $GLOBALS['servicio2'] : '';
    });
    add_shortcode('servicio3', function () {
        return isset($GLOBALS['servicio3']) ? $GLOBALS['servicio3'] : '';
    });

    add_shortcode('icono', function ($atts) {
        $atts = shortcode_atts([
            'id' => ''
        ], $atts, 'icono');
        $id = $atts['id'];
        return isset($GLOBALS[$id]) ? $GLOBALS[$id] : '';
    });
}, 11);