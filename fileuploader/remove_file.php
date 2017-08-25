<?php

include('../include.php');

if(wp_get_current_user()->roles[0] != 'administrator')
die('Insufficient Permissions.');

if(isset($_POST['file'])){
    $file = '../uploads/' . $_POST['file'];
    if(file_exists($file))
        unlink($file);
    $wpdb->query('DELETE FROM wp_files where unique_id = "' . $_POST['file'] . '"');
}
?>
