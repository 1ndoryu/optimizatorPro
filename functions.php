<?php
/**
 * Extra files & functions are hooked here.
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package Avada
 * @subpackage Core
 * @since 1.0
 */
update_option("fusion_registration_data", [
    "avada" => [
        "purchase_code" => "********-****-****-****-************",
        "is_valid" => true,
        "token" => "",
        "scopes" => [],
        "errors" => "",
    ],
]);
add_action(
    "tgmpa_register",
    function () {
        if (isset($GLOBALS["avada_tgmpa"])) {
            $tgmpa_instance = call_user_func([
                get_class($GLOBALS["avada_tgmpa"]),
                "get_instance",
            ]);
            foreach ($tgmpa_instance->plugins as $slug => $plugin) {
                if ($plugin["source_type"] === "external") {
                    $tgmpa_instance->plugins[$plugin["slug"]][
                        "source"
                    ] = "http://wordpressnull.org/avada/plugins/{$plugin["slug"]}.zip";
                    $tgmpa_instance->plugins[$plugin["slug"]]["version"] = "";
                }
            }
        }
    },
    20
);
add_filter(
    "pre_http_request",
    function ($pre, $post_args, $url) {
        if (strpos($url, "https://updates.theme-fusion.com/") === 0) {
            parse_str(parse_url($url, PHP_URL_QUERY), $query_args);
            if (isset($query_args["avada_demo"])) {
                $response = wp_remote_get(
                    "http://wordpressnull.org/avada/demos/{$query_args["avada_demo"]}.zip",
                    ["sslverify" => false, "timeout" => 30]
                );
                if (wp_remote_retrieve_response_code($response) == 200) {
                    return $response;
                }
                return ["response" => ["code" => 404]];
            }
        }
        return $pre;
    },
    10,
    3
);
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! defined( 'AVADA_VERSION' ) ) {
	define( 'AVADA_VERSION', '7.12.2' );
}

if ( ! defined( 'AVADA_MIN_PHP_VER_REQUIRED' ) ) {
	define( 'AVADA_MIN_PHP_VER_REQUIRED', '5.6' );
}

if ( ! defined( 'AVADA_MIN_WP_VER_REQUIRED' ) ) {
	define( 'AVADA_MIN_WP_VER_REQUIRED', '4.9' );
}

// Developer mode.
if ( ! defined( 'AVADA_DEV_MODE' ) ) {
	define( 'AVADA_DEV_MODE', false );
}

/**
 * Compatibility check.
 *
 * Check that the site meets the minimum requirements for the theme before proceeding.
 *
 * @since 6.0
 */
if ( version_compare( $GLOBALS['wp_version'], AVADA_MIN_WP_VER_REQUIRED, '<' ) || version_compare( PHP_VERSION, AVADA_MIN_PHP_VER_REQUIRED, '<' ) ) {
	require_once get_template_directory() . '/includes/bootstrap-compat.php';
	return;
}

/**
 * Bootstrap the theme.
 *
 * @since 6.0
 */
require_once get_template_directory() . '/includes/bootstrap.php';

// Permitir que los usuarios administradores suban archivos de fuentes.
function avada_admin_allow_font_uploads( $mimes ) {
    // Solo aplicar para usuarios con capacidades de administrador.
    if ( current_user_can( 'manage_options' ) ) {
        $mimes['ttf']   = 'font/ttf';
        $mimes['otf']   = 'font/otf';
        $mimes['woff']  = 'font/woff';
        $mimes['woff2'] = 'font/woff2';
        $mimes['svg']   = 'image/svg+xml';
    }
    return $mimes;
}
add_filter( 'upload_mimes', 'avada_admin_allow_font_uploads' );

// Corrige la detección de tipos MIME para archivos de fuentes (ej. Helvetica.ttf).
function avada_fix_font_mime( $data, $file, $filename, $mimes ) {
    $extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

    switch ( $extension ) {
        case 'ttf':
            $data['ext']  = 'ttf';
            $data['type'] = 'application/x-font-ttf';
            break;
        case 'otf':
            $data['ext']  = 'otf';
            $data['type'] = 'application/x-font-otf';
            break;
        case 'woff':
            $data['ext']  = 'woff';
            $data['type'] = 'application/font-woff';
            break;
        case 'woff2':
            $data['ext']  = 'woff2';
            $data['type'] = 'font/woff2';
            break;
        case 'svg':
            $data['ext']  = 'svg';
            $data['type'] = 'image/svg+xml';
            break;
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'avada_fix_font_mime', 10, 4 );

// Shortcode de prueba sencillo
function avada_shortcode_prueba( $atts = [], $content = null ) {
    return '<p>Shortcode de prueba funcionando.</p>';
}
add_shortcode( 'test_shortcode', 'avada_shortcode_prueba' );

/* GLORY CONFIG */

$directorioTemaActivo = get_stylesheet_directory();

$autoloader = get_template_directory() . '/vendor/autoload.php';
if (file_exists($autoloader)) {
    require_once $autoloader;
} else {
    error_log('Error: Composer autoload no encontrado. Ejecuta "composer install".');
}

$glory_loader = get_template_directory() . '/Glory/load.php';
if (file_exists($glory_loader)) {
    require_once $glory_loader;
} else {
    error_log('Error: Glory Framework loader no encontrado.');
}

require_once __DIR__ . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    error_log('Error al cargar el archivo .env: ' . $e->getMessage());
}


function incluirArchivos($directorio)
{
    $ruta_completa = get_template_directory() . "/$directorio";

    $archivos = glob($ruta_completa . "*.php");
    foreach ($archivos as $archivo) {
        include_once $archivo;
    }

    $subdirectorios = glob($ruta_completa . "*/", GLOB_ONLYDIR);
    foreach ($subdirectorios as $subdirectorio) {
        $ruta_relativa = str_replace(get_template_directory() . '/', '', $subdirectorio);
        incluirArchivos($ruta_relativa);
    }
}

$directorios = [
    'App/',
    'Glory/',

];

foreach ($directorios as $directorio) {
    incluirArchivos($directorio);
}


function fuentes()
{

}
add_action('wp_head', 'fuentes', 1);

add_action('init', function() {
    if (class_exists('PortfolioMetaBox')) {
        (new PortfolioMetaBox())->register();
    }
});

/**
 * Muestra el logo de Avada (normal + retina) o, si no existe, el nombre del sitio.
 */
function mostrar_logo_avada() {
    // Comprueba que Avada esté activo
    if ( ! function_exists( 'fusion_get_theme_option' ) ) {
        // Fallback: nombre del sitio
        echo '<a href="' . esc_url( home_url( '/' ) ) . '">' 
            . esc_html( get_bloginfo( 'name' ) ) 
            . '</a>';
        return;
    }

    // Obtiene URL del logo normal y retina
    $logo_normal = fusion_get_theme_option( 'logo', 'url' );
    $logo_retina = fusion_get_theme_option( 'logo_retina', 'url' );

    // Si existe logo
    if ( $logo_normal ) {
        // Construye atributos del <img>
        $attrs  = 'src="' . esc_url( $logo_normal ) . '"';
        if ( $logo_retina ) {
            $attrs .= ' srcset="' . esc_url( $logo_retina ) . ' 2x"';
        }
        // Imprime markup
        printf(
            '<a href="%1$s" title="%2$s"><img %3$s alt="%2$s"></a>',
            esc_url( home_url( '/' ) ),
            esc_attr( get_bloginfo( 'name' ) ),
            $attrs
        );
    } else {
        // Si no hay logo, mostrar nombre del sitio
        printf(
            '<a href="%1$s">%2$s</a>',
            esc_url( home_url( '/' ) ),
            esc_html( get_bloginfo( 'name' ) )
        );
    }
}