<?php

if (!class_exists('PortfolioMetaBox')) {
    class PortfolioMetaBox
    {
        private const POST_TYPE = 'portfolio';
        private const META_KEY = '_portfolio_metrics';
        private const NONCE_ACTION = 'app_save_portfolio_metrics';
        private const NONCE_NAME = 'app_portfolio_nonce';

        public function register(): void
        {
            add_action('add_meta_boxes', [$this, 'addMetaBox']);
            add_action('save_post_' . self::POST_TYPE, [$this, 'saveMetaData']);
        }

        public function addMetaBox(): void
        {
            add_meta_box(
                'app_portfolio_metrics',
                'Project Metrics (Before & After)',
                [$this, 'renderMetaBoxContent'],
                self::POST_TYPE,
                'normal',
                'high'
            );
        }

        public function renderMetaBoxContent(\WP_Post $post): void
        {
            wp_nonce_field(self::NONCE_ACTION, self::NONCE_NAME);
            $metrics = get_post_meta($post->ID, self::META_KEY, true);
            if (!is_array($metrics)) {
                $metrics = [];
            }
?>
            <div id="glory-metrics-container" class="app-metabox-container">
                <div class="app-metabox-header">
                    <span class="app-metabox-label">Metric Label</span>
                    <span class="app-metabox-label">Before</span>
                    <span class="app-metabox-label">After</span>
                    <span class="app-metabox-label">Actions</span>
                </div>

                <div id="glory-metrics-repeater">
                    <?php if (empty($metrics)) : ?>
                        <div class="app-metabox-row-empty">
                            No metrics added yet. Click "Add Metric" to start.
                        </div>
                    <?php else : ?>
                        <?php foreach ($metrics as $index => $metric) : ?>
                            <div class="app-metabox-row">
                                <input type="text" name="app_metrics[<?php echo $index; ?>][label]" value="<?php echo esc_attr($metric['label'] ?? ''); ?>" placeholder="e.g., Organic Traffic" class="app-metabox-input">
                                <input type="text" name="app_metrics[<?php echo $index; ?>][before]" value="<?php echo esc_attr($metric['before'] ?? ''); ?>" placeholder="Before value" class="app-metabox-input">
                                <input type="text" name="app_metrics[<?php echo $index; ?>][after]" value="<?php echo esc_attr($metric['after'] ?? ''); ?>" placeholder="After value" class="app-metabox-input">
                                <button type="button" class="button button-small glory-remove-metric-btn">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <template id="glory-metric-template">
                    <div class="app-metabox-row">
                        <input type="text" name="app_metrics[__INDEX__][label]" placeholder="e.g., Organic Traffic" class="app-metabox-input">
                        <input type="text" name="app_metrics[__INDEX__][before]" placeholder="Before value" class="app-metabox-input">
                        <input type="text" name="app_metrics[__INDEX__][after]" placeholder="After value" class="app-metabox-input">
                        <button type="button" class="button button-small glory-remove-metric-btn">Remove</button>
                    </div>
                </template>

                <div class="glory-metabox-actions">
                    <button type="button" id="glory-add-metric-btn" class="button button-primary">Add Metric</button>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const repeater = document.getElementById('glory-metrics-repeater');
                    const addButton = document.getElementById('glory-add-metric-btn');
                    const template = document.getElementById('glory-metric-template');

                    const updateIndexes = () => {
                        const rows = repeater.querySelectorAll('.app-metabox-row');
                        rows.forEach((row, index) => {
                            row.querySelectorAll('input').forEach(input => {
                                input.name = input.name.replace(/\[\d+\]|\[__INDEX__\]/, '[' + index + ']');
                            });
                        });
                    };

                    addButton.addEventListener('click', function() {
                        const emptyRowMessage = repeater.querySelector('.app-metabox-row-empty');
                        if (emptyRowMessage) {
                            emptyRowMessage.remove();
                        }
                        const newRow = template.content.cloneNode(true);
                        repeater.appendChild(newRow);
                        updateIndexes();
                    });

                    repeater.addEventListener('click', function(e) {
                        if (e.target && e.target.classList.contains('glory-remove-metric-btn')) {
                            e.target.closest('.app-metabox-row').remove();
                            if (repeater.children.length === 0) {
                                repeater.innerHTML = '<div class="app-metabox-row-empty">No metrics added yet. Click "Add Metric" to start.</div>';
                            }
                            updateIndexes();
                        }
                    });
                });
            </script>
<?php
        }

        public function saveMetaData(int $post_id): void
        {
            if (!isset($_POST[self::NONCE_NAME]) || !wp_verify_nonce($_POST[self::NONCE_NAME], self::NONCE_ACTION)) return;
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            if (!current_user_can('edit_post', $post_id)) return;

            if (isset($_POST['app_metrics']) && is_array($_POST['app_metrics'])) {
                $sanitized_metrics = [];
                foreach ($_POST['app_metrics'] as $metric) {
                    if (is_array($metric) && !empty($metric['label'])) {
                        $sanitized_metrics[] = [
                            'label'  => sanitize_text_field($metric['label']),
                            'before' => sanitize_text_field($metric['before']),
                            'after'  => sanitize_text_field($metric['after']),
                        ];
                    }
                }
                update_post_meta($post_id, self::META_KEY, $sanitized_metrics);
            } else {
                delete_post_meta($post_id, self::META_KEY);
            }
        }
    }
}
