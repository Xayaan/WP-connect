<?php

function get_c_avatar($id, $size){
    require_once( 'include.php' );

    $user_avatar = $wpdb->get_results('select * from wp_usermeta where meta_key = "wp_user_avatar" and user_id = '.$id);

    if(!empty($user_avatar)) {
        $avatar = $wpdb->get_results("SELECT * FROM wp_posts WHERE ID = " . $user_avatar[0]->meta_value);
        $avatar = '<img src="'.$avatar[0]->guid.'" class="c-i">';
    }

    return !empty($user_avatar) ? $avatar : get_avatar($id, $size);
}


?>