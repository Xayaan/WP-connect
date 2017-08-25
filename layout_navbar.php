<?php
require_once( 'include.php' );

function get_c_avatar($id, $size){

	global $wpdb;
	$avatar = '';
	$user_avatar = $wpdb->get_results('select * from wp_usermeta where meta_key = "wp_user_avatar" and user_id = '.$id);

	if($size == 50)
		$append = 'class="c-i"';
	else
		$append = 'style="width: '.$size.'px; height: '.$size.'px"';
	if(!empty($user_avatar)) {
		$avatars = $wpdb->get_results("SELECT * FROM wp_posts WHERE ID = " . $user_avatar[0]->meta_value);
		if(!empty($avatars))
			$avatar = '<img src="'.@$avatars[0]->guid.'" '.$append.'>';
	}

	return !empty($avatar) ? $avatar : get_avatar($id, $size);
}
$current_user = wp_get_current_user();
$is_admin = ($current_user->roles[0] == 'administrator');

if(!$is_admin)
	$where = ' WHERE author_id = '.$current_user->ID.' AND is_read = \'N\' AND status = "open"';
else
	$where = ' WHERE status = "queue"';

$tickets_count = $wpdb->get_var('SELECT COUNT(ID) FROM wp_aiosc_tickets '.$where);
$uploads_count = $wpdb->get_var("SELECT COUNT(id) FROM wp_files WHERE type=2 AND is_seen='N'");

if(isset($_GET['page'])){
	echo '<input id="d-hid" type="hidden" value="'.$_GET['page'].'">';
}else{
	echo '<input id="d-hid" type="hidden" value="dashboard">';
}

?>
<style>
	.c-i{
		width: 50px !important; height: 50px !important;
	}
	.pending-count{
		background-color: #d54e21;
		border-radius: 10px;
		color: #fff;
		display: inline-block;
		font-size: 9px;
		font-weight: 600;
		line-height: 17px;
		margin: 1px 0 0 2px;
		vertical-align: top;
		z-index: 26;
		padding: 1% 4% 1% 4%;
	}
</style>
<script>
	$(document).ready(function(){
		var hid = $('#d-hid').val();
		if(hid == 'create_ticket' || hid == 'support_view')
			hid = 'support_center';
		else if(hid == 'connect')
			hid = 'merchant_connect';
		$('.'+hid).addClass('open');
		$('.l-'+hid).addClass('active');

		$('#custom-li a img, .connect img').attr('style', 'border-radius: 50px !important;');
	});
</script>
<?php



?>
<nav class="ts-sidebar">
	<ul class="ts-sidebar-menu">
		<li id="custom-li"><a href="#"><?php echo get_c_avatar($current_user->ID, 50); ?> </a></li>
		<li onclick="window.href='profile.php'" style="cursor: pointer;"><h4><?php echo @$current_user->display_name; ?></h4></li>
		<li><p><?php echo @$current_user->data->user_email; ?></p></li>

		<li class="dashboard"><a href="index.php"><img src="img/rocket.png"> Dashboard</a></li>
		<li class="profile"><a href="index.php?page=profile"><img src="img/user.png">  Profile</a></li>
		<li class="rewards"><a href="index.php?page=rewards"><img src="img/plane.png"> My Rewards</a></li>
		<li class="merchant_connect"><a href="index.php?page=merchant_connect"><img src="img/connect.png"> Merchant Connect</a></li>
		<li class="support_center">
			<a href="index.php?page=support_center">
			<img src="img/help.png"/> Support Center 
			<?php if($tickets_count) { ?>
			<span class="pending-count"><?php echo $tickets_count; ?></span>
			<?php } ?>
			</a>
		</li>
		<li class="resources"><a href="index.php?page=resources"><img src="img/inbox.png">Resources</a></li>
		<?php if($is_admin) { ?>
		<li class="merchant_uploads">
			<a href="index.php?page=merchant_uploads">
			<img src="img/inbox.png"/>Merchant Uploads
			<?php if($uploads_count) { ?>
			<span class="pending-count"><?php echo $uploads_count; ?></span>
			<?php } ?>
			</a>
		</li>
		<?php } ?>
		<li class="statements"><a href="index.php?page=statements"><img src="img/statement.png"> Statements</a></li>
		<?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
			<li class="manage_advertisements"><a href="index.php?page=manage_advertisements"><img src="img/statement.png"> Manage Advertisements</a></li>
		<?php } ?>
		<?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
		<li><a href="index.php?page=wp-in-frame"><img src="img/statement.png">WP-Admin</a>
        <?php } ?>
		<li><a href="<?php echo esc_url( wp_logout_url() ); ?>"><img src="img/log_out.png">Logout</a>

		</li>

		<!-- Account from above -->
		<ul class="ts-profile-nav">
			<li class="l-dashboard"><a href="index.php"> Home  </a></li>
			<li class="l-rewards"><a href="index.php?page=rewards">My Rewards</a></li>
			<li class="l-merchant_connect"><a href="index.php?page=merchant_connect">Merchant Connect </a></li>
			<li class="l-support_center"><a href="index.php?page=support_center">Support Center </a></li>
			<li class="l-resources"><a href="index.php?page=resources">Resources</a></li>
			<li><a href="#"> 1-888-123-4567</a></li>
			<li class="live_chat"><button onclick="olark('api.box.expand')" style="text-transform: uppercase;">Live Chat</button></li>



		</ul>

	</ul>
</nav>
