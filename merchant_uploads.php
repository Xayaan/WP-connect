<?php

require_once('include.php');

?>

<script>
$(document).ready(function () {
	$(".right_arrow").css('top', $("#iframe-content").offset().top-64);
	
	$('#iframe-content').contents()
                		.find("table")
                		.scroll(function() {
                			$(".right_arrow").fadeOut("slow");
                		});
    });

</script>

<span class="right_arrow"></span>
<iframe src="../wp-admin/admin.php?page=user-panel-merchant-uploads&ifr=1" 
		id="iframe-content" 
		style="width: 100%; border: medium none ! important; height: 1500px;">
</iframe>
