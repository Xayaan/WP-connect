<?php
require_once( 'include.php' );
$current_user = wp_get_current_user();
?>
<div class="page_heading page-title">
    <p>Welcome  <?php echo $current_user->user_nicename; ?> </p>
    <h2><?php
        if(isset($_GET['page'])){
            echo ucwords(str_replace('_', ' ', $_GET['page']));
        }else{
            echo 'Dashboard';
        }
        ?></h2>
    <h3> Merchant ID: <?php echo user_panel_get_merchant_id(); ?><a href="<?php echo esc_url( wp_logout_url() ); ?>">Logout</a></h3>
</div>