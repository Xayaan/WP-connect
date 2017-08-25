<?php
include('include.php');

if(isset($_POST['action'])){
//    echo '<pre>';print_r($_POST);print_r($_FILES['file']);exit;
    if($_POST['action'] == 'send'){
        $file_id = 0;
        $to_user = $_POST['mid'];
        $from_user = wp_get_current_user()->ID;

        if($_FILES["file"]["error"] == 0){
            $target_dir = "uploads/merchant/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $wpdb->query('INSERT INTO wp_files (user_id, image, type, created_at)
                                VALUES("'.$from_user.'", "'.$_FILES["file"]["name"].'", 2, "'.date('Y-m-d H:i:s').'")');
                $file_id = $wpdb->insert_id;
            }
        }

        $wpdb->query('INSERT INTO wp_merchant (user_to, user_from, status, message, file_id, created_at, updated_at)
                  VALUES('.$to_user.', '.$from_user.', 0, "'.$_POST['message'].'", "'.$file_id.'", "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d H:i:s').'")');
        header('Location: index.php?page=connect&mid='.$to_user);
        exit;
    }
    elseif($_POST['action'] == 'archive'){
        $to_user = $_POST['value'];
        $from_user = wp_get_current_user()->ID;
        $wpdb->query('UPDATE wp_merchant SET archive = 1 WHERE (user_to = '.$to_user.' AND user_from = '.$from_user.') OR (user_from = '.$to_user.' AND user_to = '.$from_user.')');
        exit;
    }
}

if(!isset($_GET['mid'])){
    header('Location: index.php?page=merchant');exit;
}

$current_user = wp_get_current_user();

$user = $wpdb->get_results("SELECT * FROM wp_users WHERE ID = ".$_GET['mid']);

$data = $wpdb->get_results("SELECT * FROM wp_merchant WHERE ((user_to = ".$_GET['mid']."
                    AND user_from = ".$current_user->ID.") OR (user_from = ".$_GET['mid']."
                    AND user_to = ".$current_user->ID.")) AND archive = 0 ORDER BY created_at ASC");

?>
<style>
    #connect-tbl tr td{border: none !important;}
    .c-msg{width: 90% !important;}
    .c-img{width: 10% !important;}
    .c-i{width: 50px !important; height: 50px !important;}
    .file-img{width: 200px !important; height: 150px !important;}
</style>
<div class="col-md-8">
<?php $ctr = 0; foreach($data as $key => $value) { ?>

    <?php if(count($data) > 30) { ?>
        <div class="col-md-12 btn-warning">Load Previous Messages</div><br/>
    <?php } if($ctr <= 30) { ?>
        <?php
            $append = '<i class="fa fa-3x fa-file-zip-o"></i>';
            $file_upload = '';
            if($value->file_id != 0){
                if(!empty($value->message))
                    $file_upload .= '<br/>';

                $file = $wpdb->get_results('SELECT image FROM wp_files WHERE id = '.$value->file_id);
                $mediapath = 'uploads/merchant/'.@$file[0]->image;
                if(@is_array(getimagesize($mediapath)))
                    $append = '<img src="uploads/merchant/'.@$file[0]->image.'" class="file-img">';
                $file_upload .= '<center><a href="download.php?name='.@$file[0]->image.'">'.$append.'<br/>'.@$file[0]->image.'
                                </a></center>';
            }
        ?>
        <table class="table" id="connect-tbl">
            <tr class="msg-<?php echo $value->id; ?>">
                <?php if($value->user_to == $_GET['mid']) { //msg from you ?>
                    <td colspan="2" class="well c-msg" style="padding: 20px;">
                        <span style="float: right;"><a title="Archive" style="color: red;" href="javascript: void(0)" onclick="javascript: archive_ind('<?php echo $value->id; ?>')"><i class="fa fa-remove"></i></a></span>
                        <?php echo $value->message.$file_upload; ?>
                    </td>
                    <td class="connect c-img" style="vertical-align: middle; text-align: center;">
                        <?php echo get_c_avatar($current_user->ID, 50); ?><br/>
                        <small><?php echo 'You'; ?></small>
                    </td>
                <?php } else { ?>
                    <td class="connect c-img" style="vertical-align: middle; text-align: center;">
                        <?php echo get_c_avatar($user[0]->ID, 50); ?><br/>
                        <small><?php echo $user[0]->display_name; ?></small>
                    </td>
                    <td colspan="2" class="well c-msg" style="padding: 20px;">
                        <?php echo $value->message.$file_upload; ?>
                    </td>
                    <?php
                    $wpdb->query("UPDATE wp_merchant SET status = 1 WHERE id = ".$value->id);
                    ?>
                <?php } ?>
            </tr>
            <tr class="msg-<?php echo $value->id; ?>">
                <td></td>
                <td style="<?php if($value->user_to == $_GET['mid']) { //msg from you ?> float:right; <?php } else { ?> float:left; <?php } ?>">
                    <small>
                    <?php echo date('F d, Y H:i A', strtotime($value->created_at)); ?>
                    </small>
                </td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <?php $ctr += 1; } } ?>


    <form action="connect.php" method="post" enctype="multipart/form-data">
        <div class="col-md-12 text-right">
            <label style="float: left !important;">Compose Message:</label>
            <input type="hidden" name="action" value="send">
            <input type="hidden" name="mid" id="mid" value="<?php echo $_GET['mid']; ?>">
            <textarea name="message" class="form-control"></textarea><br/>
            <label style="float: left !important;">File upload:</label>
            <input type="file" name="file" class="form-control">
            <br/>
            <button class="btn btn-success">Send</button>
        </div>
    </form>
</div>


<div class="col-md-4 text-center">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                User Details</h3>
        </div>
        <ul class="list-group">
            <a class="list-group-item" href="#"><?php echo get_c_avatar($user[0]->ID, 250); ?></a>
            <a class="list-group-item" href="#"><?php echo @$user[0]->display_name; ?></a>
            <a class="list-group-item" href="#"><?php echo @$user[0]->user_email; ?></a>

            <?php
            $sql = 'select * from wp_usermeta where meta_key in("business_name", "industry_name") and user_id = '.$user[0]->ID;
            $umeta = $wpdb->get_results($sql);

            foreach($umeta as $key => $value){
                echo '<a class="list-group-item" href="#">'.$value->meta_value.'</a>';
            }
            ?>
            <a class="list-group-item" onclick="javascript: archive()"
               style="background-color: #d9534f; color: white;" href="javascript: void(0)">Delete</a>
        </ul>
    </div>



    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="text-align: left;">
                    Notification
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button  style="font-family: 'Open Sans', sans-serif !important" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a  style="font-family: 'Open Sans', sans-serif !important" href="javascript: void(0)" class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function archive(){
        $('#confirm-delete').modal('show');
        $('#confirm-delete').find('.modal-body').html('Are you sure you want to delete this conversation?');
        $('#confirm-delete').find('.btn-ok').attr('onclick', 'javascript: go()');
    }

    function go(){
        $.post("connect.php", {
            action: 'archive',
            value: $('#mid').val()
        }).done(function() {
            location.href = 'index.php?page=merchant_connect';
        });
    }

    function archive_ind(id){
        $('#confirm-delete').modal('show');
        $('#confirm-delete').find('.modal-body').html('<input type="hidden" id="mid_ind" value="'+id+'">Are you sure you want to delete this message?');
        $('#confirm-delete').find('.btn-ok').attr('onclick', 'javascript: go_ind()');
    }

    function go_ind(){
        $.post("merchant_connect.php", {
            action: 'archive',
            value: $('#mid_ind').val()
        }).done(function() {
            $('.msg-'+$('#mid_ind').val()).remove();
            $('#confirm-delete').modal('hide');
        });
    }
</script>