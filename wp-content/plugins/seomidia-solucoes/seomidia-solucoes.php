<?php
/**
 * Plugin Name:     Seomidia Solucoes
 * Text Domain:     seomidia-solucoes
 * Domain Path:     /languages
 * Version:         0.1.0
 * Author URI: https://wa.me/message/MVAVJF3YAIM6H1
 * @package         Seomidia_Solucoes
 */

 
if ( ! defined( 'ABSPATH' ) ) exit;

function my_query_by_post_meta( $query ) {
    global $wpdb;
    

    $slug = explode('/',$_SERVER['REQUEST_URI']);


    foreach ($slug as $key => $value) {
        if($value != ''){
            $post_name[] = $value;
        }
    }

    $slug = end($post_name);

    $sql  = "SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$slug}' AND post_status = 'publish' ";
    $result = $wpdb->get_results($sql);

    $category = get_the_terms( $result[0]->ID, 'course-category');

    $args = [
            [ 
                'taxonomy' => 'course-category', 
                'field' => 'slug', 
                'terms' => [$category[0]->slug]
            ]
    ];
    
    $query->set('tax_query',$args);
}
add_action( 'elementor/query/filtro_cat', 'my_query_by_post_meta' );