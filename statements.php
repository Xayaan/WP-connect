




    <div class="row inner_padding">

        <div class="marchent merchent_center panel">
            <div class="top_bar">
                <h4><img src="img/what.png"> Statements</h4>
                <div class="serch_right my_rewards">
                    <div class="serch_bar">
                        <?php if(wp_get_current_user()->roles[0] == 'administrator') { ?>
                            <button type="button" style="float: left;" onclick="javascript: add_s()">Add Statement</button>
                        <?php } ?>
                    </div>
                </div>

            </div>

            <div id="tbl-response" class="table-responsive">Loading...</div><!--table-responsive-->

        </div>

        <div class="modal fade" id="addStatement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Add Statement</h4>
                    </div>
                    <div class="modal-body"> </div>
                    <div class="modal-footer">
                        <button type="button" style="font-family: 'Open Sans', sans-serif !important" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" onclick="javascript: submit_this()" class="btn btn-success submit-dd" data-dismiss="modal">Submit</button>
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
            $.get("statements_ajax.php", function (resp) {
                $('#tbl-response').html(resp);
                $('#tbl-response').prepend('<span class="right_arrow"></span>');
                $(".right_arrow").css('top',$("table:visible tr:first").offset().top-110);
                $("table").scroll(function() {
                    $(".right_arrow").fadeOut("slow");
                });
            });
        }

        function add_s(){
            $('#addStatement').modal('show');
            $('#addStatement').find('.modal-body').html('Loading...');
            $('#addStatement').find(".modal-body").load('add_statements.php');
        }

        function submit_this(){
            var error = '';
            $.each($('.required'), function(){
                if($.trim($(this).val()) == '')
                    error = 'Please fill up required fields.';
            });
            if(error == '') {
                $('#add-statement-form').submit();
            }else{
                $('#notification').modal('show');
                $('#notification').find('.modal-body').html(error);
            }
        }
    </script>



