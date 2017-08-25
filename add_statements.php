<?php
include('include.php');

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if(isset($_POST['action'])){
    if($_POST['action'] == 'submit'){
        $params = $_POST;

        
        $target_file = '';

        if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0)
        {
            $target_dir = "uploads/" . generateRandomString(24);
            mkdir($target_dir);

            $target_file = $target_dir . "/" . basename($_FILES["fileToUpload"]["name"]);

            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        }

        $ret = $wpdb->query("INSERT INTO wp_statements (year, month, filepath, created_at, user_id)
              VALUES(".$params['year'].","
              .$params['month'].",'"
              .$target_file."', '"
              .date('Y-m-d H:i:s')."',". $params['user_id'] ." )");

        header('Location: index.php?page=statements');
        exit;
    }
}

$data = $wpdb->get_results("SELECT * FROM wp_users WHERE ID != ".wp_get_current_user()->ID." ORDER BY display_name ASC");

?>
<form action="add_statements.php" method="post" id="add-statement-form" enctype="multipart/form-data">
     <label>User</label>
    <select name="user_id" class="form-control">
            <?php foreach($data as $key => $value){ ?>
                <option value="<?php echo $value->ID; ?>"><?php echo $value->display_name; ?></option>
            <?php } ?>
    </select>
    <input type="hidden" name="action" value="submit">
    <label>Year</label>
    <select name="year" type="text" class="form-control required">
        <?php 
        $currentYear = intval(date("Y"));
        for($year = $currentYear - 5; $year < $currentYear + 10;$year++) { ?>
        <option value="<?php echo($year);?>" <?php if($year == $currentYear) { echo("selected"); }?>><?php echo($year); ?></option>
        <?php } ?>
    </select>
    <label>Month</label>
    <select name="month" type="text" class="form-control required">
        <?php 
        for($i = 1; $i < 13;$i++) { 
            $dateObj   = DateTime::createFromFormat('!m', $i);
            $monthName = $dateObj->format('F'); // March
            ?>
        <option value="<?php echo($i); ?>"><?php echo($monthName); ?></option>
        <?php } ?>
    </select>
    <label>File</label>   
    <input type="file" name="fileToUpload" class="form-control required">
</form>

<style>
    #ui-datepicker-div{
        background: #ccc !important;
        padding-right: 1%;
    }
</style>
<script>
    $(function () {
        $(document).ready(function(){
            $("#datetimepicker1").datepicker({
                todayBtn:  1,
                autoclose: true,
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#datetimepicker2').datepicker('setStartDate', minDate);
            });

            $("#datetimepicker2").datepicker()
                .on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#datetimepicker1').datepicker('setEndDate', minDate);
                });
        });
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