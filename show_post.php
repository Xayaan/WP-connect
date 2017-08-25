<?php

if(!isset($_GET['pid']) || !is_numeric($_GET['pid']))
{
	include('dashboard.php');
}
else
{
	global $wpdb;
	$post_id = $_GET['pid'];
	$query = 'SELECT * FROM wp_posts WHERE ID = '.$post_id.' AND post_status = "publish" and post_type = "post"';
	$post = $wpdb->get_row($query, OBJECT, 0);

	$author = $wpdb->get_row("SELECT display_name FROM wp_users WHERE ID=".$post->post_author);
?>
<div class="col-md-12">
        <div class="marchent merchent_center panel">
            <div class="top_bar">
                <h4><img src="img/what.png"> News</h4>
            </div>

            <div class="center_msg">
				<div class="row">
                <div class="col-md-12">
		    		<h2><?php echo $post->post_title; ?></h2>
		    		<p>
		    		Posted by <?php echo $author->display_name; ?> 
		    		on <?php echo date('M d, Y H:i A', strtotime($post->post_date)); ?>
		    		</p>
		    		<br><br><br>
		    	</div>
		    	<div class="col-md-8 col-md-push-2" style="text-align: justify;">
		    		<?php echo $post->post_content; ?>
		    	</div>	
				</div>
			</div>
		</div>
</div>
<?php
}
?>