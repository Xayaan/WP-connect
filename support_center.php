<?php

require_once( 'include.php' );

if(isset($_POST)){
    $params = $_GET;
    if(isset($params['action'])){
        if($params['action'] == 'delete'){
            $wpdb->query("DELETE FROM wp_aiosc_tickets WHERE ID = ".$params['id']);
            echo 1;exit;
        }
    }
}
$dep = $wpdb->get_results('SELECT * FROM wp_aiosc_departments');
//echo "<pre>";
//print_r($dep);
//exit;
?>
<style>
    @media screen and (max-width: 1406px) {
        .serch_right.crete_ticket > a {
            padding:10px;
            font-size: 15px;
        }
    }

    @media screen and (max-width: 1320px) {
        .serch_right select {
            width: 122px;
        }
        .serch_bar input#search {
            width: 150px;
        }
    }

    @media (max-width: 991px) {
    .right_arrow {
        padding-left: 25px;
        background: url(img/forward.png) no-repeat top left;
        display: block;
        height: 64px;
        width: 64px;
        position: absolute;
        top: 57%;
        left: 80%;
        z-index: 999;
        }
    } 

    @media screen and (max-width: 640px) {
        .serch_right.crete_ticket > a {
            width: 100%;
            font-size:20px;
        }
        select#department {
            float: left;
            margin-right:10px;
        }
        .serch_bar button {
            width: 100px
        }
    }

    @media screen and (max-width: 557px) {

        select#department {
            float: left;
            margin-right:10px;
        }
        input#search {
            float: left;
        }
        .serch_bar button {
            width: 100px
        }
    }

    @media screen and (max-width: 552px) {

        select#department {
            float: left;
            margin-right:10px;
        }
        input#search {
            float: left;
        }
        .serch_bar button {
            font-size:13px;
            padding:5px;
            width: 75px;
            height: 42px;
        }
    }

    @media screen and (max-width: 527px) {

        select#department {
            float: left;
            width: 120px;
            margin-left: -25%;
        }
        .serch_bar button {
            padding:5px;
            font-size: 14px;
            width: 40%;
            height: 42px;
            float: right;
        }
        .serch_bar input#search {
            float: left;
            width: 110px
        }
    }

    @media screen and (max-width: 420px) {
        .serch_bar {
            margin-left: 13%;
        }

        select#department {
            width: 75%;
            margin-left: 5%;
        }
        input#search {

            margin-left: 5%;
        }
        .serch_bar button {
            float:left;
            padding:5px;
            width: 30%;
            height: 42px;
        }
    }

</style>

<div class="row inner_padding">
    <div class="col-md-12">
        <div class="marchent merchent_center panel">
            <div class="top_bar serch_right" style="margin-bottom: 10px;">
                <a href="index.php?page=create_ticket" style="float: right; background:#0aa699;" class="text-center" style="margin-bottom: 10px;">Create Ticket </a>
                <h4><img src="img/what.png"> Tickets</h4>
            </div>

            <div class="center_msg">
                <div class="row">
                    <div class="col-lg-7 col-lg-push-5 col-md-12">
                        <div class="serch_right crete_ticket" style="width: 100%">
                            <form action="#" method="post">
                                <div class="serch_bar" style="width: 100%">
                                    <div class="col-md-3" style="padding: 0px;padding-right: 5px;">
                                        <select id="department" name="department" style="width: 100%;">
                                            <option value="0">Please Select</option>
                                            <?php foreach($dep as $key => $value) {?>
                                                <option value="<?php echo @$value->ID; ?>"> <?php echo @$value->name; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6" style="padding: 0px;padding-right: 15px;">
                                        <input style="width: 100%;" id="search" name="search" type="text" placeholder="Search by # or string">
                                    </div>
                                    <div class="col-md-3" style="padding: 0px">
                                        <button style="width: 100%;height: 42px;" type="button" onclick="javascript: load_table(5);">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>	 
		    <div class="col-lg-5 col-lg-pull-7 col-md-12">
                        <ul class="msg_status">
                            <li class="lis active li-1"><a href="javascript: void(0)" onclick="javscript: load_table(1);">All <span id="t-1"></span></a></li>
                            <li class="lis li-2"><a href="javascript: void(0)" onclick="javscript: load_table(2);">In Queue <span id="t-2"></span></a></li>
                            <li class="lis li-3"><a href="javascript: void(0)" onclick="javscript: load_table(3);">Opened <span id="t-3"></span></a></li>
                            <li class="lis li-4"><a href="javascript: void(0)" onclick="javscript: load_table(4);">Closed <span id="t-4"></span></a></li>
                        </ul>
                    </div>   
                </div>
            </div>
            <div id="tbl-response" class="table-responsive">Loading...</div><!--table-responsive-->

        </div>
    </div>

</div>

<script>
    $(document).ready(function(){
        load_table(1);
    });

    $('#search').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            load_table(5);
            e.preventDefault();
            return false;
        }
    });

    function action_this(id){
        if (confirm("Are you sure?") == true) {
            $.post("support_center.php?action=delete&id="+id, function (resp) {
                $('.ticket-tr-'+id).remove();
            });
        }
    }

    function load_table(type){
        $('#tbl-response').html('Loading...');

        if(type != 5)
        {
            $('.lis').removeClass('active');
            $('.li-'+type).addClass('active');
        }

        var dept = $('#department').val();
        var search = $.trim($('#search').val());
        var params = 'department='+dept+'&search='+search+"&type="+$(".msg_status").find(".active").find("span").attr('id').substr(2,3);

        $.get("support.php?"+params, function (resp) {
            $('#tbl-response').html(resp);
            $('#tbl-response').prepend('<span class="right_arrow"></span>');
            $(".right_arrow").css('top',$("table:visible tr:first").offset().top-110);
            $("table").scroll(function() {
                $(".right_arrow").fadeOut("slow");
            });
            var $response = $(resp);
            for (i = 1; i <= 4; i++) {
                $('#t-' + i).text('(' + $response.filter('#t-' + i).text() + ')');
            }
        });
    }
</script>


