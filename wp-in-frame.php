<?php

/** WordPress Administration Bootstrap */
require_once ABSPATH . 'wp-admin/includes/admin.php';

$user = wp_get_current_user();
$user_id = $user->data->ID;

?>

<iframe id="inner_frame" src="../wp-admin/"" style="width: 100%; border: medium none ! important; height: 2200px;"></iframe>

