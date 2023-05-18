<?php
/*
Plugin Name: QuerY ID
Description: 
Author: kAIOHENRIQUE
Version: 1.0.0
*/

function get_user_id( $user_id = 0 ) {
    if ( ! $user_id ) {
        return get_current_user_id();
    }

    return $user_id;
}

function get_enrolled_courses_ids_by_user( $user_id = 0 ) {
    global $wpdb;
    $user_id    = get_user_id( $user_id );
    $course_ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT DISTINCT post_parent
        FROM 	{$wpdb->posts}
        WHERE 	post_type = %s
                AND post_status = %s
                AND post_author = %d
            ORDER BY post_date DESC;
        ",
            'tutor_enrolled',
            'completed',
            $user_id
        )
    );

    return $course_ids;
}

function get_enrolled_courses_ids() {
    global $wpdb;

    $sql = "SELECT ID FROM {$wpdb->posts} where post_type = 'courses' AND post_status = 'publish'";
    $result = $wpdb->get_results($sql);

    $course_ids = [];

    foreach ($result as $value) {
       $course_ids[] = $value->ID;
    }

    return $course_ids;
}



function custom_query_callback_meus( $query ) {
	
    global $wpdb;

    $user_id    = get_user_id( get_current_user_id() );
    $course_ids = array_unique( get_enrolled_courses_ids_by_user( $user_id ) );

    $query->set('post__in',$course_ids);
}
add_action( 'elementor/query/meus_cursos', 'custom_query_callback_meus' );

function custom_query_callback_outros( $query ) {
	
    global $wpdb;

    $user_id    = get_user_id( get_current_user_id() );
    $course_ids = array_unique( get_enrolled_courses_ids_by_user( $user_id ) );
    $course_ids2 = array_unique( get_enrolled_courses_ids());

    $curso = $course_ids;
    foreach ($course_ids as $key => $value) {
        $key = array_search($value, $course_ids2);
        if($key!==false){
            unset($course_ids2[$key]);
        }
    }

    $query->set('post__in',$course_ids2);
}
add_action( 'elementor/query/outros_cursos', 'custom_query_callback_outros' );