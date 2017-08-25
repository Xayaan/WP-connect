<div class="row inner_padding">
    <div class="col-md-12">
        <div class="marchent merchent_center panel">
            <div class="top_bar">
                <h4><img src="img/adv_1.png"> Manage Advertisements</h4>
                <div class="serch_right my_rewards">
                </div>
            </div>

            <div id="upload_success" style="background-color: #0aa699 ; padding: 20px; text-align: center" class="text-white animated fadeIn hide"><h4><i class="fa fa-check"></i> &nbsp; Upload successful</h4></div>
            <div id="upload_failed" style="background-color: #e75735; padding: 20px; text-align: center" class="text-white animated fadeIn hide"><h4><i class="fa fa-remove"></i>&nbsp; Upload failed. Please make sure that you have the right file </h4></div>
            <ul class="form_upload">
                <li id="file_placeholder" style="width: 100%;border: 1px dashed #dcdcdc;font-size:16px; margin-bottom: 10px;">No files available</li>
                <!--                <li><i aria-hidden="true" class="fa fa-file-text-o"></i>-->
                <!--                    <p>BMS FORM</p>-->
                <!--                    <a href="">Download</a>-->
                <!--                </li>-->
            </ul>

            <div class="drage_page upload-btn">
                <input type="file" id="filer_input3" name="files[]">
            </div>
            
        </div>
    </div>
</div>

<script>
    function getfiles() {
        $.ajax({
            type: "GET",
            url: "./fileuploader/read_dir.php?ads=1",
            dataType: "json",
            cache: false,
            success: function(result){
                // get path name of wp-connect directory
                var loc = window.location.pathname;
                var dir = loc.substring(0, loc.lastIndexOf('/'));

                $.each(result, function(index, val) {
                    //val = val.image;
                    var imageDisplayName = val.image;
                    console.log(val);
                    var imageStoreName = val.unique_id;
                    if (imageDisplayName.split('.').pop() == 'jpg' || imageDisplayName.split('.').pop() == 'jpeg' || imageDisplayName.split('.').pop() == 'png') {
                        $('li#file_placeholder').hide();
                        var filename = imageDisplayName.slice(0, imageDisplayName.lastIndexOf("."));
                        var date_uploaded = imageDisplayName.substr(imageDisplayName.lastIndexOf("_") + 1);
                        var month_filter = date_uploaded.slice(0, date_uploaded.indexOf("."));
                        var unique_id = filename.replace(/ /g,"_").toString().toLowerCase();
                        var link = '';

                        append = '<i class="fa fa-remove" onclick="delete_file(\''+ imageStoreName +'\')" style="font-size: 15px; color: darkred; float: right;cursor:pointer;margin-top:0px"></i>';

                        $('ul.form_upload').append(
                            '<li class="all ' + month_filter +' file_li">' + append +
                            '<img  class="img-responsive" style="width:100%; max-width: 500px; margin-top: 15px;" src="uploads/'+ imageStoreName +'" alt=""> <br>' +
                            '<p title="'+ filename +' - '+ month_filter +'">'+ filename +'</p>' +
                            '<a href="javascript:void(0)" style="display: none"data-toggle="modal" data-target="#update_link_modal" onclick="update_ad_link(\''+ unique_id +'\')">Update link</a>' +
                            '</li>'
                        );
                    }
                });
            }
        });
    }

    function update_ad_link(new_link) {
        $('#update_link_modal').find('.modal-body').html('Loading...');
        $('#update_link_modal').find(".modal-body").load('./fileuploader/update_file.php?id='+new_link);
    }

    function submit_this(){
        $.post('./fileuploader/update_file.php', {unique_id: $('#hd_link').val(), link: $('#new_link').val(), action: 'update_link'});
        $('ul.form_upload').fadeOut('fast').html('').fadeIn('fast');
        getfiles();
    }

    function delete_file(filename) {
        $.post('./fileuploader/remove_file.php', {file: filename, action: 'advertisement'});
        $('ul.form_upload').fadeOut('fast').html('').fadeIn('fast');
        getfiles();
    }

    $(document).ready(function() {

        // get profile page into iframe

        // read files and list them up
        getfiles();

        // Detect change in Date Filter
        $('select#file_select_month').on('change', function() {
            var str = "";
            $( "select#file_select_month option:selected" ).each(function() {
                str += $( this ).val();
            });

            // trigger filter
            switch(str) {
                case str:
                    $('.file_li').not('.' + str).fadeOut('fast');
                    $('.' + str).fadeIn('fast');
                    break;
            }
        }).change();

        //Example 2
        $("#filer_input3").filer({
            limit: null,
            maxSize: null,
            extensions: null,
            changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><span><i class="fa fa-cloud-upload"></i></span> <p>Upload Advertisement Image</p></div></div></div>',
            showThumbs: true,
            theme: "dragdropbox",
            templates: {
                box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                item: '<li class="jFiler-item">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-info">\
                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                    </div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li>{{fi-progressBar}}</li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
                itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                            <span class="jFiler-item-others">{{fi-size2}}</span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: false,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
            },
            dragDrop: {
                dragEnter: null,
                dragLeave: null,
                drop: null,
            },
            uploadFile: {
                url: "./fileuploader/upload.php?ads=1",
                data: {'ads' : 1},
                type: 'POST',
                enctype: 'multipart/form-data',
                beforeSend: function(){
                    var filter = $('input[type=file]').val().split('\\').pop().replace(/^.*\./, '');
                    if ( filter == 'png' || filter == 'jpeg' || filter == 'jpg' ) {
                        return true;
                    } else {
                        $('#upload_success').addClass('hide');
                        $('#upload_failed').removeClass('hide');
                        return false;
                    }
                },
                success: function(data, el){
                    console.log(data);
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                    });

                    // read files and list them up
                    var file_list = $('ul.form_upload');
                    file_list.fadeOut('fast');
                    file_list.html('');
                    getfiles();
                    file_list.fadeIn('fast');

                    $('#upload_failed').addClass('hide');
                    $('#upload_success').removeClass('hide');
                },
                error: function(el){
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                },
                statusCode: null,
                onProgress: null,
                onComplete: null
            },
            files: null,
            addMore: false,
            clipBoardPaste: true,
            excludeName: null,
            beforeRender: null,
            afterRender: null,
            beforeShow: null,
            beforeSelect: null,
            onSelect: null,
            afterShow: null,
            onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
                var file = file.name;
                $.post('./fileuploader/remove_file.php', {file: file});
            },
            onEmpty: null,
            options: null,
            captions: {
                button: "Choose Files",
                feedback: "Choose files To Upload",
                feedback2: "files were chosen",
                drop: "Drop file here to Upload",
                removeConfirmation: "Are you sure you want to remove this file?",
                errors: {
                    filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                    filesType: "Only Images are allowed to be uploaded.",
                    filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                    filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
                }
            }
        });

    });
</script>


<!-- Modal -->
<div class="modal fade" id="update_link_modal" tabindex="-1" role="dialog" aria-labelledby="update_link_modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="update_link_modalLabel"><img src="img/adv_1.png" alt=""> Update Advertisement Link</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer form-upload">
                <button type="button" onclick="javascript: submit_this()" class="btn btn-success submit-dd" data-dismiss="modal">Save Changes</button>
            </div>
        </div>
    </div>
</div>