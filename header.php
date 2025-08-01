<?php

/**
 * Header template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if (! defined('ABSPATH')) {
    exit('Direct script access denied.');
}
?>
<?php
use Glory\Components\HeaderRenderer;
?>

<!DOCTYPE html>
<html class="<?php avada_the_html_class(); ?>" <?php language_attributes(); ?>>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php Avada()->head->the_viewport(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
    <?php wp_head(); ?>

    <?php
    /**
     * The setting below is not sanitized.
     * In order to be able to take advantage of this,
     * a user would have to gain access to the database
     * in which case this is the least of your worries.
     */
    echo apply_filters('avada_space_head', Avada()->settings->get('space_head')); // phpcs:ignore WordPress.Security.EscapeOutput
    ?>
</head>

<?php
$object_id      = get_queried_object_id();
$c_page_id      = Avada()->fusion_library->get_page_id();
$wrapper_class  = 'fusion-wrapper';
$wrapper_class .= (is_page_template('blank.php')) ? ' wrapper_blank' : '';
?>

<body <?php body_class(); ?> <?php fusion_element_attributes('body'); ?>>
    <?php do_action('avada_before_body_content'); ?>
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'Avada'); ?></a>

    <div id="boxed-wrapper">
        <?php if ('boxed' === Avada()->settings->get('layout')) : ?>
            <?php if ('framed' === Avada()->settings->get('scroll_offset')) : ?>
                <div class="fusion-sides-frame"></div>
            <?php endif; ?>
        <?php endif; // End of boxed mode check. 
        ?>

        <div id="wrapper" class="<?php echo esc_attr($wrapper_class); ?>">
            <div id="home" style="position:relative;top:-1px;"></div>
            <?php if (apply_filters('awb_should_render_header', true, $c_page_id)) : ?>

                <?php HeaderRenderer::render(); ?>

            <?php endif; ?>

            <?php avada_current_page_title_bar($c_page_id); ?>

            <?php
            $row_css    = '';
            $main_class = '';

            if (apply_filters('fusion_is_hundred_percent_template', false, $c_page_id)) {
                $row_css    = 'max-width:100%;';
                $main_class = 'width-100';
            }

            if (fusion_get_option('content_bg_full') && 'no' !== fusion_get_option('content_bg_full')) {
                $main_class .= ' full-bg';
            }
            do_action('avada_before_main_container');
            ?>
            <main id="main" class="clearfix main contentAjax <?php echo esc_attr($main_class); ?>">
                <div class="fusion-row" style="<?php echo esc_attr($row_css); ?>">