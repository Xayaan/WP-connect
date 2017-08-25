<?php
include('include.php');

$months = array('', 'January', 'Februay', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
?>

<div class="row inner_padding">
    <div class="col-md-12">
        <?php if(isset($_GET['s'])) { if($_GET['s'] == 1) { ?>
            <div class="col-md-12 btn-success">
                Request Submitted!
            </div>
        <?php } } ?>
        <div class="marchent merchent_center panel">
            <div class="top_bar">
                <h4><img src="img/rewards.png"> Rewards</h4>
                <div class="serch_right my_rewards">
                    <div class="serch_bar">
                        <?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
			<button type="button" style="float: left;" onclick="javascript: form_th(0)">Add Reward</button>&nbsp;
                        <?php } ?>
			<button type="button" style="float: left;margin-left: 1%;" onclick="javascript: redeem()">Redeem Points</button>
                        <select class="form-control" id="months-slct" style="width: 150px !important;height: 41px;">
                            <option value="0">Select Month</option>
                            <?php foreach($months as $key => $value) { if(!empty($value)) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } } ?>
                        </select> &nbsp;
                        <button type="button" onclick="javascript: load_rewards()">Apply</button> &nbsp;
                    </div>
                </div>

            </div>

            <div id="tbl-response" class="table-responsive">Loading...</div><!--table-responsive-->

        </div>
    </div>

    <div class="modal fade" id="rewardsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Data</h4>
                </div>
                <div class="modal-body"> </div>
                <div class="modal-footer">
                    <button type="button"  style="font-family: 'Open Sans', sans-serif !important" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button"  style="font-family: 'Open Sans', sans-serif !important" onclick="javascript: submit_this()" class="btn btn-success submit-dd" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function(){
        
        load_table();
    });

    function load_table(){
        $('#tbl-response').html('Loading...');
        $.get("rewards_ajax.php", function (resp) {
            $('#tbl-response').html(resp);
            $('#tbl-response').prepend('<span class="right_arrow"></span>');
            $(".right_arrow").css('top',$("table:visible tr:first").offset().top-110);
            $("table").scroll(function() {
                $(".right_arrow").fadeOut("slow");
            });
        });
    }

    function load_rewards(){
        if($('#months-slct option:selected').val() != 0){
            $('.months').hide();
            $('.'+$('#months-slct option:selected').text()).show();
        }else
            $('.months').show();
    }

    function view_th(id){
        var modal = $('#rewardsModal');
        var data = $('.dd-'+id).html();
        modal.find('.modal-title').text('Data');
        modal.find('.modal-body').html('<style>.submit-dd{display: none;}</style>'+data);
        $('#rewardsModal').modal('show');
    }

    function form_th(id){
        $('#rewardsModal').modal('show');
        $('#rewardsModal').find('.modal-body').html('Loading...');
        $('#rewardsModal').find(".modal-body").load('add_rewards.php?id='+id);
    }

    function submit_this(){
        $('#add-reward-form').submit();
    }
</script>


