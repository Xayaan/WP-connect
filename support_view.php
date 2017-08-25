<?php

require_once( 'include.php' );

$append = '';
if(isset($_GET['action'])) {
    if ($_GET['action'] == 'edit') {
        $append = '&edit_mode=1';
    }
}
?>

<iframe src="../wp-admin/admin.php?page=aiosc-ticket-preview&ticket_id=<?php echo $_GET['ticket_id']; ?><?php echo $append; ?>&ifr=1" style="width: 100%; border: medium none ! important; height: 1500px;"></iframe>
