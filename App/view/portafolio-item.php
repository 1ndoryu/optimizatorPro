<?php

function portfolioItem(WP_Post $post, string $itemClass): void
{
    // Obtiene el array completo de métricas
    $metrics = get_post_meta($post->ID, '_portfolio_metrics', true);

    // Obtiene la nueva descripción corta
    $short_description = get_post_meta($post->ID, 'short_description', true);

    if (!is_array($metrics)) {
        $metrics = [];
    }
?>
    <div class="<?php echo esc_attr($itemClass); ?> portfolioCaseStudy">
        <div class="caseStudyContent">
            <h3 style="margin: 0; margin-bottom: 1rem;"><?php the_title(); ?></h3>
            <div class="caseStudyDescription">
                <?php
                // Se usa la descripción corta en lugar de the_content()
                if (!empty($short_description)) {
                    echo wp_kses_post(wpautop($short_description));
                }
                ?>
            </div>

            <?php if (!empty($metrics)) : ?>
            <div class="caseStudyMetrics">
                <div class="metricsHeader">
                    <span class="metricLabel">VALUE</span>
                    <span class="metricTimeLabel">BEFORE</span>
                    <span class="metricTimeLabel">AFTER</span>
                </div>

                <?php foreach ($metrics as $metric) :
                    $label  = $metric['label'] ?? 'N/A';
                    $before = $metric['before'] ?? '0';
                    $after  = $metric['after'] ?? '0';
                ?>
                <div class="metricRow">
                    <span class="metricLabel"><?php echo esc_html(strtoupper($label)); ?></span>
                    <span class="metricValue before"><?php echo esc_html($before); ?></span>
                    <span class="metricValue after">
                        <span class="animated-value" data-start-value="<?php echo esc_attr($before); ?>" data-final-value="<?php echo esc_attr($after); ?>">
                            <?php echo esc_html($before); ?>
                        </span>
                    </span>
                </div>
                <?php endforeach; ?>
                
            </div>
            <?php endif; ?>
        </div>
        <div class="caseStudyImage">
            <?php if (has_post_thumbnail()) : ?>
                <?php
                // Se obtiene la URL de la imagen en lugar de imprimir la etiqueta img
                $image_url = get_the_post_thumbnail_url($post->ID, 'large');
                ?>
                <div class="image-background" style="background-image: url('<?php echo esc_url($image_url); ?>');"></div>
            <?php else : ?>
                <div class="imagePlaceholder"></div>
            <?php endif; ?>
        </div>
    </div>
<?php
}