<?php

include('../include.php');

if(isset($_POST['action'])){
    if($_POST['action'] == 'update_link')
        $wpdb->query('UPDATE wp_files SET link = "'.$_POST['link'].'" where unique_id = "' . $_POST['unique_id'] . '"');

}

$data = $wpdb->get_results('SELECT * FROM wp_files WHERE unique_id = "'.$_GET['id'].'"');

?>

<h4 id="ad_title"><?php echo str_replace('_', ' ', ucwords(@$data[0]->unique_id)); ?></h4>
<input type="hidden" id="hd_link" style="width:100%" class="form-control" value="<?php echo @$data[0]->unique_id; ?>">
<input type="text" id="new_link" style="width:100%" class="form-control" value="<?php echo @$data[0]->link; ?>">


