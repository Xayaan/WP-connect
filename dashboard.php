<script>
	$(document).ready(function(){
		$(".div-connect, .div-support").height($(".marchent").height());
		$(".div-adv").height($('.div-what').height());
	})
</script>
<div class="row inner_padding">
    <div class="col-md-4">
        <div class="marchent div-rewards panel">
            <h3><img src="img/plane_big.png">Merchant Rewards</h3>
            <!--<div class="marchemt_block">

                <a href="index.php?page=amazon">Amazon</a>
                <a href="index.php?page=travel">Travel</a>
            </div>-->

            <div class="merchent_dis">	<p>My Rewards <br/><?php
                    $points = $wpdb->get_results('SELECT * FROM wp_rewards WHERE user_id = '.wp_get_current_user()->ID);
                    $inc = 0;
                    if (!is_array($points)) {
                    	$points = [];
                    }
                    foreach($points as $key => $value){
                        $inc += $value->total;
                    }
                    echo $inc; ?></p></div>
            <a href="javascript: void(0)" onclick="javascript: redeem()">Redeem Points</a>
        </div>
    </div>



    <div class="col-md-4">
        <div class="marchent div-connect panel">
            <h3><img src="img/connect_large.png">Merchant Connect</h3>

            <?php include('merchant.php'); ?>

            <a  class="view_all" href="index.php?page=merchant_connect" style="position: absolute;right: 6%;bottom: 8%;">View All</a>


        </div>
    </div>


    <div class="col-md-4">
        <div class="marchent div-support panel">
            <h3><img src="img/help_big.png">   Support Center</h3>

            <?php include('support_dashboard.php'); ?>
            <div class="btn_all sup-all" style="position: absolute;bottom: 8%;margin: auto;width: 88%;">
                <a href="javascript: void(0)" onclick="olark('api.box.expand')" style="padding: 10px 0 10px 0px;text-transform: uppercase;margin: 0">Live Chat</a>
                <a class="view_black" style="padding: 10px 0px 10px 0px;margin: 0" href="index.php?page=support_center">VIEW ALL</a>
                <a class="crete_ticket specialsnowflake" style="padding: 10px 0px 10px 0px;margin: 0; width: 105px;" href="index.php?page=create_ticket">CREATE TICKET</a>
            </div>


        </div>
    </div>



</div>




<div class="row margin_bottom">
    <div class="col-md-8">
        <div class="wht_on div-what panel">
            <h4><img src="img/what.png">News</h4>
            <?php
            $posts = $wpdb->get_results('SELECT * FROM wp_posts WHERE post_status = "publish" and post_type = "post" ORDER BY ID DESC');
            if (!is_array($posts)) {
            	$posts = [];
            }
            foreach ($posts as $key => $value) { ?>
                <div class="what_dis">
					<img src="img/msg.png">
					<div class="p_dis">
						<a href="index.php?page=show_post&pid=<?php echo $value->ID; ?>">
							<h3><?php echo $value->post_title; ?></h3>
							<p><?php echo $value->post_content; ?></p>
						</a>
					</div>
					<div class="what_time">
						<p> <?php echo date('M d, Y \a\t g:ia', strtotime($value->post_date)); ?></p>
					</div>
                </div>
            <?php } ?>
        </div>
    </div>


    <div class="col-md-4">
        <div class="wht_on div-adv panel">
            <h4><img src="img/adv_1.png">Advertisement</h4>
            <div class="adverties">
                <?php $ad_slide = $wpdb->get_results('SELECT * FROM wp_files WHERE type = 1');?>

                <div id="carousel-ads" class="" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?php $ctr = 0;?>
                        <?php
                        	if (!is_array($ad_slide)) {
                        		$ad_slide = [];
                        	}
                        ?>
                        <?php foreach($ad_slide as $ad) { ?>
							<?php $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', ''); $ext = pathinfo($ad->unique_id, PATHINFO_EXTENSION); if(in_array($ext, $image)){ ?>
								<li data-target="#carousel-ads" data-slide-to="<?php echo $ctr++?>" class=""></li>
							<?php }?>
                        <?php }?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php foreach($ad_slide as $ad) { ?>
							<?php $image = array('jpg', 'jpeg', 'png', 'gif', 'bmp', ''); $ext = pathinfo($ad->unique_id, PATHINFO_EXTENSION); if(in_array($ext, $image)){ ?>
								<div class="item">
									<a <?php echo !empty($ad->link) ? 'href="'.$ad->link.'"' : ''; ?> target="_blank"><img src="uploads/<?php echo $ad->unique_id?>" alt="Advertisement"></a>
								</div>
							<?php }?>
                        <?php }?>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-ads" role="button" data-slide="prev">
                        <span class="fa" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-ads" role="button" data-slide="next">
                        <span class="fa" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('ready', function() {
        $('#carousel-ads').addClass('carousel slide');
        $('#carousel-ads > .carousel-indicators > li:first-child').addClass('active');
        $('#carousel-ads > .carousel-inner > .item:first-child').addClass('active');
        $('.wht_on.div-adv').attr('style', 'height:auto !important')
    });
</script>