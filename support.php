<?php

require_once( 'include.php' );

$selectedTicketStatus = isset($_GET['type']) ? $_GET['type'] : 0;

$current_user = wp_get_current_user();
$sql = '';
$where = '';
$sql_p = "SELECT * FROM wp_aiosc_tickets ";

if($selectedTicketStatus == 2){
    $sql .= " WHERE status = 'queue'";
}elseif($selectedTicketStatus == 3){
    $sql .= " WHERE status = 'open'";
}elseif($selectedTicketStatus == 4){
    $sql .= " WHERE status = 'closed'";
}

if($current_user->roles[0] != 'administrator'){
    if(strstr($sql, 'WHERE')){
        $sql .= ' AND ';
    }else{
        $sql .= " WHERE ";
    }
    $sql .= ' author_id = '.$current_user->ID;
    $where .= ' WHERE author_id = '.$current_user->ID;
}

if(isset($_GET['department']) || isset($_GET['search'])){
    if(strstr($sql, 'WHERE')){
        $sql .= ' AND ';
    }else{
        $sql .= " WHERE ";
    }

    if(intval($_GET['search']) != 0)
    {
        $sql .= 'ID = ' . intval($_GET['search']);
        if(!empty($_GET['department']))
        {
            $sql .= 'AND department_id = '.$_GET['department'];

        }
    }
    else
    {
        if(!empty($_GET['department']))
        {
            $sql .= ' department_id = '.$_GET['department'].' AND ';

        }
        $sql .= ' (subject like "%'.$_GET['search'].'%" OR content like "%'.$_GET['search'].'%")';
    }
}

$sql .= ' ORDER BY date_created DESC';

$tickets = $wpdb->get_results($sql_p.$sql);
$cnt = $wpdb->get_results($sql_p.$where);

$department = array();
$dep = $wpdb->get_results('SELECT * FROM wp_aiosc_departments');
if (!is_array($dep)) {
	$dep = [];	
}
foreach($dep as $key => $value){
    $department[$value->ID] = $value->name;
}

if(true) {
    $priorities = array();
    $prio = $wpdb->get_results('SELECT * FROM wp_aiosc_priorities');
    if (!is_array($prio)) {
    	$prio = [];
    }
    foreach ($prio as $key => $value) {
        $priorities[$value->ID] = $value->name;
    }
}

$ctr = array();
if (!is_array($cnt)) {
	$cnt = [];
}
foreach($cnt as $key => $value){
    @$ctr['total'] += 1;
    @$ctr[$value->status] += 1;
}

//echo "<pre>";
//print_r($sql_p.$where);
//exit;

?>
<span style="display: none;" id="t-1"><?php echo isset($ctr['total']) ? $ctr['total'] : 0; ?></span>
<span style="display: none;" id="t-2"><?php echo isset($ctr['queue']) ? $ctr['queue'] : 0; ?></span>
<span style="display: none;" id="t-3"><?php echo isset($ctr['open']) ? $ctr['open'] : 0; ?></span>
<span style="display: none;" id="t-4"><?php echo isset($ctr['closed']) ? $ctr['closed'] : 0; ?></span>
<table class="table table-hover support_table">
    <thead>
    <tr class="table_haedimg">
        <th width="5%">ID</th>
        <th>Subject</th>
        <th>Status</th>
        <th>Priority</th>
        <th>Department</th>
        <th>Date Created</th>
        <th>Last Update</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($tickets)){
        foreach($tickets as $key => $value) {
	    $is_not_admin = wp_get_current_user()->roles[0] != 'administrator';
            ?>
            <tr class="ticket-tr-<?php echo $value->ID; ?> <?php echo (($is_not_admin&&$value->is_read=='N')?'font-bold':'');?>">
                <td> #<?php echo $value->ID; ?></td>
                <td>
                    <a href="index.php?page=support_view&ticket_id=<?php echo $value->ID; ?>">
                        <?php echo $value->subject; ?>
                    </a>
                    <?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
                        <br/>
                        <small><a href="index.php?page=support_view&ticket_id=<?php echo $value->ID; ?>&action=edit">Edit</a> |
                            <a href="javascript: void(0)" onclick="javascript: action_this(<?php echo $value->ID; ?>)">Delete</a></small>
                    <?php } ?>
                </td>
                <td><a href="" class="support_<?php echo strtolower($value->status); ?>"><?php echo $value->status == 'open' ? 'Opened' : ucwords($value->status); ?></a></td>
                    <td> <b><?php echo @$priorities[$value->priority_id]; ?></b> </td>
                    <td><?php echo @$department[$value->department_id]; ?> </td>
                    <td> <?php echo date('F d, Y H:i A', strtotime($value->date_created)); ?>  </td>
                    <td> <?php echo date('F d, Y H:i A', strtotime($value->last_update)); ?></td>
            </tr>
            <?php
        }
    }else{
        ?>
        <tr>
            <td colspan="6" style="text-align: center;">No data found.</td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
