<?php
/**
 * Plugin Name: QSM Custom Filters
 * Description: Adiciona filtros personalizados para o QSM (Quiz and Survey Master).
 */

// Enqueue custom scripts and styles
function qsm_custom_filters_scripts() {
    wp_enqueue_style('qsm-custom-filters-style', plugins_url('qsm-custom-filters.css', __FILE__));
    wp_enqueue_script('qsm-custom-filters-script', plugins_url('qsm-custom-filters.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'qsm_custom_filters_scripts');

// Add custom filter HTML
function qsm_custom_filters_html() {
    ob_start();
        ?>
        <div class="qsm-custom-filters">
            <input type="text" id="qsm-custom-search" placeholder="Pesquisar pergunta...">
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'qsm_category',
                'hide_empty' => false,
            ));
            print_r($categories);
                ?>
                <select id="qsm-custom-category">
                    <option value="">Todas as categorias</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo esc_attr($category->term_id); ?>"><?php echo esc_html($category->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
            
            ?>
        </div>
        <?php
    return ob_get_clean();
}
add_shortcode('qsm_custom_filters', 'qsm_custom_filters_html');
