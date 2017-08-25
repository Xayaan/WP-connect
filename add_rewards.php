<?php
include('include.php');

if(isset($_POST['action'])){
    if($_POST['action'] == 'submit'){
        $params = $_POST;
        $total = $params['earned'] - $params['redeem'];

        if(isset($_POST['user'])){

            $wpdb->query("INSERT INTO wp_rewards (user_id, month, earn, redeem, date, reward, total, created_at)
                  VALUES(".$_POST['user'].", '".$params['month']."', '".$params['earned']."', '".$params['redeem']."',
                  '".date('Y-m-d H:i:s', strtotime($params['date']))."', '".$params['reward']."', '".$total."', '".date('Y-m-d H:i:s')."')");

        }else{

            $wpdb->query('UPDATE wp_rewards SET month = '.$params['month'].', earn = '.$params['earned'].',
                        redeem = '.$params['redeem'].', date = "'.date('Y-m-d H:i:s', strtotime($params['date'])).'", reward = "'.$params['reward'].'", total = '.$total.',
                        updated_at = "'.date('Y-m-d H:i:s').'" WHERE id = '.$params['id']);

        }

        header('Location: index.php?page=rewards');
        exit;
    }
}

$data = $wpdb->get_results("SELECT * FROM wp_users WHERE ID != ".wp_get_current_user()->ID." ORDER BY display_name ASC");

?>
<link rel="stylesheet" href="css/jquery.ui.datepicker.min.css">
<script src="../wp-includes/js/jquery/ui/datepicker.min.js"></script>
<style></style>
<form action="add_rewards.php" method="post" id="add-reward-form">
    <input type="hidden" name="action" value="submit">
    <label>Month</label>
    <select class="form-control" name="month">
        <option value="">Select Month</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
    <br/>
    <?php if($_GET['id'] != 0) { ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <?php }else{ ?>
        <label>User</label>
        <select name="user" class="form-control">
            <?php foreach($data as $key => $value){ ?>
                <option value="<?php echo $value->ID; ?>"><?php echo $value->display_name; ?></option>
            <?php } ?>
        </select>
    <?php } ?>
    <br/>
    <label>Points Earned</label>
    <input type="text" name="earned" class="form-control" onkeypress="return isNumber(event)">
    <br/>
    <label>Redeemed</label>
    <input type="text" name="redeem" class="form-control" onkeypress="return isNumber(event)">
    <br/>
    <label>Date</label>
    <input type="text" name="date" class="form-control" id="datetimepicker1">
    <br/>
    <label>Rewards</label>
    <input type="text" name="reward" class="form-control">
</form>

<style>
    #ui-datepicker-div{
        background: #ccc !important;
        padding-right: 1%;
    }
</style>
<script>
    $(function () {
        $('#datetimepicker1').datepicker();
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>