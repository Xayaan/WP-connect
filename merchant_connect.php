<?php
include('include.php');
if(isset($_POST['action'])){
	if($_POST['action'] == 'archive'){
		$id = $_POST['value'];
		$wpdb->query('UPDATE wp_merchant SET archive = 1 WHERE id = '.$id);
		exit;
	}
}

$data = $wpdb->get_results("SELECT * FROM wp_users WHERE ID != ".wp_get_current_user()->ID." ORDER BY display_name ASC");

$users = array();
if (!is_array($data)) {
	$data = [];
}
foreach($data as $key => $value){
	$users[$value->ID]['name'] = $value->display_name;
	/*meta*/
	$sql = 'select * from wp_usermeta where meta_key in("user_panel_id","business_name", "industry_name") and user_id = '.$value->ID;
	$umeta = $wpdb->get_results($sql);

	if($umeta != 0){
		foreach($umeta as $k => $v){
			@$users[$value->ID][@$v->meta_key] = @$v->meta_value;
		}
	}
}
?>

<div class="row inner_padding">

	<div class="col-md-12">
		<div class="marchent merchent_center panel">
			<div class="top_bar">
				<h4><img src="img/what.png"> <span  id="charts_text">Charts</span></h4>
			</div>

		<div class="center_msg">
			<div class="row">
					<div class="col-md-12 col-lg-8 col-lg-push-4 text-right">
					<div class="serch_right">
								<a href="javascript: void(0)" onclick="javascript: show_directory(0);" style="margin-right: 1%;">Messages</a> &nbsp;
								<a href="javascript: void(0)" onclick="javascript: show_directory(1);">Directory</a> &nbsp;
								<form action="#" method="post" class="pull-right">
									<div class="serch_bar">
										<input type="text" name="search" id="search" placeholder="Search by # or string">
										<button type="button" onclick="javascript: load_table(5)">Search</button>
									</div>
								</form> &nbsp;
					</div>
					</div>
					<div class="col-md-12 col-lg-4 col-lg-pull-8">
						<ul class="msg_status">
								<li class="lis active li-1"><a href="javascript: void(0)" onclick="javscript: load_table(1);">All <span id="t-1"></span></a></li>
								<li class="lis li-2"><a href="javascript: void(0)" onclick="javscript: load_table(2);">Unread <span id="t-2"></span></a></li>
								<li class="lis li-3"><a href="javascript: void(0)" onclick="javscript: load_table(3);">Read <span id="t-3"></span></a></li>
                                <li class="lis li-4"><a href="javascript: void(0)" onclick="javscript: load_table(4);">Sent <span id="t-4"></span></a></li>
						</ul>
					</div>
					<span class="right_arrow"></span>
			</div>
		</div>

			<div id="tbl-response" class="table-responsive">
			Loading...
			</div>
			
			<!--table-responsive-->
			<div id="tbl-directory" class="table-responsive" style="display: none;">
				<div class="col-md-12">
					<table class="table table-hover">
						<tr>
							<th>Merchant Name</th>
							<th>Business Name</th>
							<th>Industry Name</th>
							<th>Action</th>
						</tr>
						<?php
						$i = 1;
						foreach($users as $key => $value) {
						?>
							<tr class="ui-all u-<?php echo $i++; ?>">
								<td><?php echo @$value['name']; ?><br><small>ID:&nbsp;<?php echo @$value['user_panel_id']; ?></small></td>
								<td><?php echo @$value['business_name']; ?></td>
								<td><?php echo @$value['industry_name']; ?></td>
								<td class="serch_bar">
									<a href="index.php?page=connect&mid=<?php echo $key; ?>">Connect</a>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div><!--table-responsive-->
		</div>

	</div>

	<script>

		$('#search').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) {
				e.preventDefault();
				return false;
			}
		});

		function show_directory(type){
			if(type == 1) {
				$('#charts_text').text("Directory");
				$('.msg_status').hide();
				$('#tbl-response').hide();
				$('#tbl-directory').show();
				$(".right_arrow").css('top',$("table:visible tr:first").offset().top-110);
				$(".right_arrow").fadeIn("slow");
			} else {
				$('#charts_text').text("Charts");
				$('#tbl-directory').hide();
				$('#tbl-response').show();
				$('.msg_status').show();
				$(".right_arrow").css('top',$("table:visible tr:first").offset().top-110);
				$(".right_arrow").fadeIn("slow");
			}
		}

		$(document).ready(function(){
			load_table(1);
		});

		function load_table(type){
			/*directory*/
			if($.trim($('#search').val()) != '') {
				for (i = 1; i < $("#tbl-directory tr").size(); i++) {
					$('.u-'+i).hide();
					var n = $('.u-' + i).text().includes($.trim($('#search').val()));
					if(n == true)
						$('.u-'+i).show();
				}
			}else
				$('.ui-all').show();

			/*message*/
			$('.lis').removeClass('active');
			$('.li-'+type).addClass('active');
			$('#tbl-response').html('Loading...');
			var append = '';
			if($.trim($('#search').val()) != '')
				append = '&search='+$.trim($('#search').val());

			$.get("merchant.php?type="+type+append, function (resp) {
				console.log(resp);
				$('#tbl-response').html(resp);
				var $response = $(resp);
				for(i=1;i<=3;i++){
					$('#t-'+i).text('('+$response.filter('#t-'+i).text()+')');
				}
				$("table").scroll(function() {
					$(".right_arrow").fadeOut("slow");
	 			});
			});
		}
	</script>



