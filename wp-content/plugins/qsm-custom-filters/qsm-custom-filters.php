<?php

/**
 * Plugin Name: QSM Custom Filters
 * Description: Adiciona filtros personalizados para o QSM (Quiz and Survey Master).
 */

function transformString($str)
{
    // Transforma a primeira letra em maiúscula
    $str = ucfirst($str);

    // Substitui o caractere "-" por espaço
    $str = str_replace('-', ' ', $str);

    return $str;
}

// Enqueue custom scripts and styles
function qsm_custom_filters_scripts()
{
    wp_enqueue_style('select2-style', plugins_url('select2.min.css', __FILE__));
    wp_enqueue_script('select2-script', plugins_url('select2.min.js', __FILE__), array('jquery'), '1.0', true);

    wp_enqueue_script('phpUnserialize-script', plugins_url('phpUnserialize.js', __FILE__), '', '1.0', true);

    wp_enqueue_style('qsm-custom-filters-style', plugins_url('qsm-custom-filters.css', __FILE__));
    wp_enqueue_script('qsm-custom-filters-script', plugins_url('qsm-custom-filters.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script('qsm-custom-filters-script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'qsm_custom_filters_scripts');

function qsm_add_comment()
{
    global $wpdb;

    if (isset($_POST['question_id']) && isset($_POST['comment'])) {

        $tableName = $wpdb->prefix . 'mlw_comments';

        $data = array(
            'question_id' => $_POST['question_id'],
            'comment_text' => $_POST['comment'],
        );

        $results = $wpdb->insert($tableName, $data);

        $query = $wpdb->prepare("SELECT * FROM $tableName WHERE question_id = %d ORDER BY created_at DESC", $_POST['question_id']);

        $response = array(
            'message' => 'Comentário cadastrado com sucesso!',
            'comments' => $wpdb->get_results($query)
        );

        if ($results) {
            wp_send_json_success($response);
        } else {
            wp_send_json_error('Erro ao cadastrar o comentário.');
        }
    }
    wp_send_json_error('Dados de comentário ausentes.');
}
add_action('wp_ajax_qsm_add_comment', 'qsm_add_comment');
add_action('wp_ajax_nopriv_qsm_add_comment', 'qsm_add_comment');

function qsm_filters_questions()
{
    global $wpdb;

    $questionsTermsTable  = $wpdb->prefix . 'mlw_questions_terms';
    $questionsTable = $wpdb->prefix . 'mlw_questions'; 

    if (isset($_POST['filters'])) {
        // Constrói a query SQL com base na lista de IDs
        $ids = implode(',', $_POST['filters']);
        $query = "SELECT q.* FROM $questionsTable q INNER JOIN $questionsTermsTable qt ON q.question_id = qt.question_id WHERE qt.term_id IN ($ids)";
        // Executa a consulta SQL
        $results = $wpdb->get_results($query);

        wp_send_json_success($results);
    }

    wp_send_json_error('Dados de comentário ausentes.');
}

add_action('wp_ajax_qsm_filters_questions', 'qsm_filters_questions');
add_action('wp_ajax_nopriv_qsm_filters_questions', 'qsm_filters_questions');


function qsm_get_comments()
{
    global $wpdb;

    $tableName = $wpdb->prefix . 'mlw_comments';

    $query = $wpdb->prepare("SELECT * FROM $tableName WHERE question_id = %d ORDER BY created_at DESC", $_POST['question_id']);

    $response = array(
        'message' => 'Comentário cadastrado com sucesso!',
        'comments' => $wpdb->get_results($query)
    );

    wp_send_json_success($response);
}

add_action('wp_ajax_qsm_get_comments', 'qsm_get_comments');
add_action('wp_ajax_nopriv_qsm_get_comments', 'qsm_get_comments');

function qsm_custom_filters_html()
{
    ob_start();
?>
    <form action="POST" method="post" id="form_filters">
        <div class="row">
            <div class="col-md-12">
                <input type="text" id="qsm-custom-search" placeholder="Pesquisar pergunta...">
            </div>
            <?php
            global $wpdb;

            $terms = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "terms");
            $array = array();

            foreach ($terms as $term) {
                $category = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "term_taxonomy WHERE term_taxonomy_id = $term->term_id LIMIT 1");
                if ($category[0]->status) {
                    $array[$category[0]->taxonomy][] = $term;
                }
            }

            foreach ($array as $category => $terms) { ?>
                <div class="col-md-4 form-group mb-2">
                    <div class="q-select-input dropdown close" id="discipline_ids">
                        <div class="dropdown-toggle form-control" data-toggle="dropdown" aria-expanded="true">
                            <span class="q-placeholder"><?= ucfirst(str_replace('-', ' ', $category)) ?></span>
                            <span class="q-count-<?= $category ?>"></span>
                            <i class="caret"></i>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                        <div class="dropdown-menu">
                            <div class="q-dropdown-content">
                                <div class="q-search-input">
                                    <label class="sr-only" for="quick-search">Busca rápida</label>
                                    <input type="text" class="form-control" placeholder="Busca rápida" aria-label="Busca rápida" id="quick-search" data-no-summary="">
                                </div>
                                <div class="q-hidden-inputs"></div>
                                <div class="selected-items"></div>
                                <ul class="q-options">
                                    <?php foreach ($terms as $term) { ?>
                                        <li tabindex="0">
                                            <label class="checkbox">
                                                <input type="checkbox" id="<?= $category ?>" name="discipline_ids[]" value="<?= $term->term_id ?>" data-summary-label="Disciplina" data-summary-display="<?= $term->name ?>" onchange="updateItemCount('<?= htmlspecialchars($category, ENT_QUOTES) ?>')">
                                                <span><?= $term->name ?></span>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <div class="q-dropdown-footer">
                                    <button type="button" class="js-close-select-dropdown-btn btn btn-default">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <button type="submit">Filtrar</button>
        </div>
    </form>
<?php
    return ob_get_clean();
}
add_shortcode('qsm_custom_filters', 'qsm_custom_filters_html');
