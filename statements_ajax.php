<?php
include('include.php');

$where = '';
if(wp_get_current_user()->roles[0] != 'administrator')
    $where = ' WHERE user_id = '.wp_get_current_user()->ID;

$data = $wpdb->get_results("SELECT * FROM wp_statements ".$where." ORDER BY created_at DESC");

$user = $wpdb->get_results("SELECT * FROM wp_users");

$users = array();
foreach($user as $key => $value){
    $users[$value->ID] = $value->display_name;
}

?>


<table class="table table-hover">
    <thead>
    <tr class="table_haedimg">
        <th>Date</th>
        <th>File</th>
        <?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
        <th>User</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php if(!empty($data)) { foreach($data as $key => $value) { ?>
        <tr class="unread_msg">
            <td> <?php echo @$value->year; ?> / <?php echo @$value->month; ?>   </td>
            <td><a href="<?php echo $value->filepath; ?>"><?php echo basename($value->filepath) ?></a></td>
            <?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
            <td> <?php echo @$users[$value->user_id]; ?>  </td>
            <?php } ?>
        </tr>
    <?php } } else{ echo '<tr><td colspan="5" style="text-align: center;">No data found.</td></tr>'; } ?>
    </tbody>
</table>
