<?php
include('include.php');
if(is_user_logged_in() != 1)
	header('Location: ../wp-admin/');
?>
<?php include('layout_header.php') ?>
<?php include('layout_top_header.php') ?>
<body>
<div class="ts-main-content">
	<?php include('layout_navbar.php') ?>
	<div class="content-wrapper">
		<div class="container-fluid">

			<div class="row ">
				<?php include('layout_content_header.php') ?>

				<div class="col-md-12">
					<?php
					if(isset($_GET['page'])){
						if($_GET['page'] == 'profile') {
							include('profile.php');
						}elseif($_GET['page'] == 'wp-in-frame'){
							include('wp-in-frame.php');
						}elseif($_GET['page'] == 'rewards'){
							include('rewards.php');
						}elseif($_GET['page'] == 'merchant_connect'){
							include('merchant_connect.php');
						}elseif($_GET['page'] == 'connect'){
							include('connect.php');
						}elseif($_GET['page'] == 'support_center'){
							include('support_center.php');
						}elseif($_GET['page'] == 'create_ticket'){
							include('create_ticket.php');
						}elseif($_GET['page'] == 'support_view'){
							include('support_view.php');
						}elseif($_GET['page'] == 'resources'){
							include('resources.php');
						}elseif($_GET['page'] == 'merchant_uploads'){
							include('merchant_uploads.php');
						}elseif($_GET['page'] == 'amazon' || $_GET['page'] == 'travel'){
							include('amazon.php');
						}elseif($_GET['page'] == 'statements'){
							include('statements.php');
						}elseif($_GET['page'] == 'manage_advertisements'){
							include('manage_advertisements.php');
						}elseif($_GET['page'] == 'show_post'){
							include('show_post.php');
						}elseif($_GET['page'] == 'shane'){
							include('install_wp_statements.php');
						}else{
							include('dashboard.php');
						}
					}else{
						include('dashboard.php');
					}


					?>
				</div>
			</div>
		</div>

	</div>
</div>
<?php include('layout_scripts.php') ?>
</body>


</html>
