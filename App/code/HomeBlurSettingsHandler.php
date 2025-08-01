<?php

namespace App\Code;

use Glory\Handler\Form\FormHandlerInterface;
use Glory\Core\OpcionRepository;

class HomeBlurSettingsHandler implements FormHandlerInterface
{
    public function procesar(array $postDatos, array $archivos): array
    {
        if (!current_user_can('edit_theme_options')) {
            throw new \Exception('No tienes permisos para realizar esta acción.');
        }

        $opciones = [
            'home_blur_effect_enabled',
            'home_blur_opacity',
            'home_blur_amount',
            'home_blur_circle1_top',
            'home_blur_circle1_left',
            'home_blur_circle2_top',
            'home_blur_circle2_left'
        ];

        foreach ($opciones as $opcion) {
            // El key en postDatos no tiene el prefijo 'home_blur_'
            $postKey = str_replace('home_blur_', '', $opcion);

            if (isset($postDatos[$postKey])) {
                $valor = sanitize_text_field($postDatos[$postKey]);
                OpcionRepository::save($opcion, $valor);
            }
        }

        return ['alert' => 'Ajustes del efecto blur guardados.'];
    }
}
