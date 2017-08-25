<?php

/** WordPress Administration Bootstrap */
require_once ABSPATH . 'wp-admin/includes/admin.php';

$user = wp_get_current_user();
$user_id = $user->data->ID;

?>

<iframe id="inner_frame" src="../wp-admin/user-edit.php?user_id=<?php echo $user_id; ?>&ifr=1" style="width: 100%; border: medium none ! important; height: 2200px;"></iframe>
<script type="text/javascript">
$( document ).ready(function(){
	$('#inner_frame').load(function(){
	console.log("js read");
	console.log($('#inner_frame').contents());
	$('#inner_frame').contents().find("#wpadminbar").remove();
	$('#inner_frame').contents().find("#adminmenumain").remove();
	$('#inner_frame').contents().find('#wpcontent').attr('style','margin-left : 0px');
	});

})
	
</script>

