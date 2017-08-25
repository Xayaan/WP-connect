<?php
include('include.php');

$user = $wpdb->get_results("SELECT * FROM wp_users");

$users = array();
foreach($user as $key => $value){
    $users[$value->ID] = $value->display_name;
}

$where = '';
if(wp_get_current_user()->roles[0] != 'administrator')
    $where = ' WHERE user_id = '.wp_get_current_user()->ID;

$data = $wpdb->get_results("SELECT * FROM wp_rewards ".$where." ORDER BY updated_at DESC");

$months = array('', 'January', 'Februay', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');


?>
<style>
    .for_review{ background-color: rgb(217, 83, 79) !important; }
    table tr.for_review:hover{background-color: rgb(217, 83, 79) !important; }
    table tr.for_review > td{ color: white ! important; }
    .alink{color: white !important; text-decoration: underline !important;}
</style>
<table class="table table-hover support_table">
    <thead>
    <tr class="table_haedimg">
        <th width="15%"> Month	</th>
        <th>points earned   </th>
        <th>redeemed	</th>
        <th> date</th>
        <th>total points</th>
        <th>  rewards	</th>
        <?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
            <th>  user	</th>
            <th>  data	</th>
            <th>  action	</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>

    <?php $total = 0; $ctr = 0; if(!empty($data)){ foreach($data as $key => $value) { ?>

        <?php if($value->month == 0 && wp_get_current_user()->roles[0] != 'administrator') { ?>
            <?php $ctr += 1; ?>
        <?php } else { ?>
        <?php $alink = $value->month == 0 ? 'alink' : ''; ?>

            <tr class="<?php echo @$months[$value->month]; ?> months <?php if($value->month == 0) { ?> for_review <?php } ?>" >
                <?php if($value->month != 0) { ?>
                    <td>  <?php echo @$months[$value->month]; ?>   </td>
                    <td> <?php echo $value->earn; ?>    </td>
                    <td>  <?php echo $value->redeem; ?>   </td>
                    <td> <?php echo $value->date == '' ? '' : date('Y-m-d', strtotime($value->date)); ?></td>
                    <td> <?php echo $value->total; ?>  </td>
                    <td> <?php echo $value->reward; ?>  </td>
                <?php }else{ ?>
                    <td colspan="6">For Review</td>
                <?php } ?>
                <?php if(wp_get_current_user()->roles[0] == 'administrator') {

                    $display = '';
                    if(!empty($value->data)) {
                        $display = '<table class="table table-hover">';
                        $string_split = explode("//" , $value->data);

                        $display .= '<tr><td>' . ucwords("Travel Type") . '</td><td>' . ucfirst($string_split[0]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Trip Type") . '</td><td>' . ucfirst($string_split[1]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("From") . '</td><td>' . ucfirst($string_split[2]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Include From") . '</td><td>' . ucfirst($string_split[2]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("To ") . '</td><td>' . ucfirst($string_split[3]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Include To ") . '</td><td>' . ucfirst($string_split[4]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Leave") . '</td><td>' . ucfirst($string_split[5]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Return ") . '</td><td>' . ucfirst($string_split[6]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Search 3") . '</td><td>' . ucfirst($string_split[7]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Adults") . '</td><td>' . ucfirst($string_split[8]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Seniors") . '</td><td>' . ucfirst($string_split[9]) . '</td></tr>';
                        $display .= '<tr><td>' . ucwords("Children") . '</td><td>' . ucfirst($string_split[10]) . '</td></tr>';
                        $display .= '</table>';
                    } else{
                        $display .= 'Nothing to show';
                    }

                    echo '<td>'.@$users[$value->user_id].'</td>
                                <td><a href="javascript: void(0)" onclick="javascript: view_th('.$value->id.')">
                                    <small class="'.$alink.'">View</small></a>
                                    <div class="dd-'.$value->id.'" style="display:none;">'.$display.'</div></td>
                                <td><a href="javascript: void(0)" onclick="javascript: form_th('.$value->id.')">
                                    <small class="'.$alink.'">Set Reward</small></td>'; } ?>
            </tr>

        <?php } ?>

        <?php @$total += $value->total; } } else{
        echo '<tr><td colspan="9" style="text-align: center;">No data available.</td></tr>'; } ?>

        <?php if($ctr > 0){
            echo '<tr class="for_review"><td colspan="6">'.$ctr.' Application/s For Review</td></tr>';
         } ?>
    </tbody>
</table>
<?php if(wp_get_current_user()->roles[0] != 'administrator') { ?>
    <h4 class="total_points">Total Points Available :  <?php echo $total; ?> </h4>
<?php } ?>