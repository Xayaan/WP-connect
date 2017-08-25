<?php
include('include.php');

$type = isset($_GET['type']) ? $_GET['type'] : 0;

/*users*/
$data = $wpdb->get_results("SELECT * FROM wp_users  ORDER BY display_name ASC");
if (!is_array($data)) {
	$data = [];
}
$users = array();
foreach($data as $key => $value){
    $users[$value->ID] = $value->display_name;
}
/**/

$current_user = wp_get_current_user();
$where = '';
$sql_p = "SELECT * FROM wp_merchant ";

if($type == 2){
    $where .= " WHERE status = 0";
}elseif($type == 3){
    $where .= " WHERE status = 1";
}

if(strstr($where, 'WHERE')){
    $where .= ' AND ';
}else{
    $where .= " WHERE ";
}

if ($type == 4) {
   $where .= " user_from = ".wp_get_current_user()->ID;
} else {
    $where .= " user_to = ".wp_get_current_user()->ID.' AND archive = 0 ';
}

if(isset($_GET['search'])){
    $where .= ' AND message LIKE "%'.$_GET['search'].'%"';
}

if ($type==4) {
   $wherea = " where user_from = ".wp_get_current_user()->ID;
} else {
    $wherea = " WHERE user_to = ".wp_get_current_user()->ID.' AND archive = 0 ';
}
$order = " ORDER BY updated_at DESC";

if($type == 0)
    $order .= " LIMIT 3";
$data = $wpdb->get_results($sql_p.$where.$order);
$ctn = $wpdb->get_results($sql_p.$wherea);
if (!is_array($ctn)) {
 $ctn = [];
}

//    echo "<pre>";
//    print_r($sql_p.$where.$order);
//    exit;

$ctr = array();

foreach($ctn as $key => $value){
    @$ctr['total'] += 1;
    if($value->status == 0)
        @$ctr['unread'] += 1;
    else
        @$ctr['read'] += 1;
}
?>
<style>
	.merchant-tbl tr td{vertical-align: middle !important;}
	.view-msg{
		background: #ccc none repeat scroll 0 0;
		border: medium none;
		color: #818181;
		display: inline-block;
		font-size: 12px;
		padding: 8px !important;
        text-align: center;
	}
</style>
<span style="display: none;" id="t-1"><?php echo isset($ctr['total']) ? $ctr['total'] : 0; ?></span>
<span style="display: none;" id="t-2"><?php echo isset($ctr['unread']) ? $ctr['unread'] : 0; ?></span>
<span style="display: none;" id="t-3"><?php echo isset($ctr['read']) ? $ctr['read'] : 0; ?></span>
<?php if($type == 0) { ?>
<?php if(!empty($data)){ foreach($data as $key => $value) { ?>
            <?php
                /*meta*/
                $sql = 'select * from wp_usermeta where meta_key in("business_name", "industry_name", "description_of_business") and user_id = '.$value->user_from;
                $umeta = $wpdb->get_results($sql);
                $meta = array();
                if($umeta != 0){
                    foreach($umeta as $k => $v){
                        $meta[$v->meta_key] = $v->meta_value;
                    }
                }
            ?>

    <?php

        $user_avatar = $wpdb->get_results('select * from wp_usermeta where meta_key = "wp_user_avatar" and user_id = '.$value->user_from);

        if(!empty($user_avatar)) {
            $avatart = $wpdb->get_results("SELECT * FROM wp_posts WHERE ID = " . $user_avatar[0]->meta_value);
            $avatar = '<img src="'.@$avatart[0]->guid.'" class="c-i">';
        }

    ?>

    <ul class="marchent_connect connect">
        <li><a href="index.php?page=connect&mid=<?php echo $value->user_from; ?>"><h3><?php echo get_c_avatar($value->user_from, 50); ?> <?php echo isset($meta['business_name']) ? $meta['business_name'] : 'Business Name Not Set'; ?></h3></a>
            <?php if($value->status == 0) { ?> <span>1</span> <?php } ?>
        </li>
    </ul>
    <?php } } ?>
<?php }else{ ?>
    <table class="table table-hover merchant-tbl">
        <?php if($type != 0){ ?>
            <thead>
            <tr class="table_haedimg">
                <th style="width: 13% !important;">merchant name<?php echo ($type==4) ? '(to)' : '(from)'; ?></th>
                <th style="width: 13% !important;">business name    </th>
                <th style="width: 12% !important;">Industry</th>
                <th style="width: 20% !important;">Description of Business</th>
                <th style="width: 30% !important;">Message	</th>
				<th style="width: 12% !important;">&nbsp;</th>
				<th>&nbsp;</th>
            </tr>
            </thead>
        <?php } ?>
        <tbody>
        <?php if(!empty($data)){ foreach($data as $key => $value) { ?>
            <?php
                /*meta*/
                $sql = 'select * from wp_usermeta where meta_key in("business_name", "industry_name", "business_desc") and user_id = '.$value->user_from;
                $umeta = $wpdb->get_results($sql);
                $meta = array();
                if($umeta != 0){
                    foreach($umeta as $k => $v){
                        $meta[$v->meta_key] = $v->meta_value;
                    }
                }
            ?>
            <tr id="msg-<?php echo $value->id; ?>" <?php if($value->status == 0){ echo 'class="unread_msg"'; } ?> >
                <td> <?php if($value->status == 0){ echo '<img src="img/dot_blue.png">'; } echo (($type==4) ? @$users[$value->user_to] : @$users[$value->user_from]); ?> 	</td>
                <td> <?php echo @$meta['business_name']; ?>  </td>
                <td> <?php echo @$meta['industry_name']; ?>    	</td>
                <td> <?php echo !empty($meta['business_desc']) ? $meta['business_desc'] : '<small>Not Set</small>'; ?>    	</td>
                <td> <?php echo substr($value->message, 0, 30); ?></td>
				<td style="width: 12% !important;"> <?php echo '<a style="float: right;" href="index.php?page=connect&mid='.$value->user_from.'">View full message</a>'; ?> </td>
                <td><a title="Archive" style="color: red;" href="javascript: void(0)" onclick="javascript: archive('<?php echo $value->id; ?>')"><i class="fa fa-remove"></i></a></td>
            </tr>
        <?php } } else{ echo "<tr><td colspan='4' style='text-align: center;'>No data available.</td></tr>"; } ?>
        </tbody>
    </table>


    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="text-align: left;">
                    Notification
                </div>
                <div class="modal-body">
                    <input type="hidden" id="mid" value="">
                    Are you sure you want to DELETE this message?
                </div>
                <div class="modal-footer">
                    <button type="button"  style="font-family: 'Open Sans', sans-serif !important" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a href="javascript: void(0)" style="font-family: 'Open Sans', sans-serif !important" onclick="javascript: go()" class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function archive(id){
            $('#mid').val(id);
            $('#confirm-delete').modal('show');
        }

        function go(){
            $.post("merchant_connect.php", {
                action: 'archive',
                value: $('#mid').val()
            }).done(function() {
                $('#msg-'+$('#mid').val()).remove();
                $('#confirm-delete').modal('hide');
            });
        }
    </script>
<?php } ?>
