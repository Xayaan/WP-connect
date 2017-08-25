<script>
	$(document).ready(function(){
		$("#leave").datepicker({
			todayBtn:  1,
			autoclose: true,
			}).on('changeDate', function (selected) {
				var minDate = new Date(selected.date.valueOf());
				$('#return').datepicker('setStartDate', minDate);
			});

		$("#return").datepicker()
			.on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#leave').datepicker('setEndDate', minDate);
        });
	});

    /*
    olark('api.chat.onOperatorsAvailable', function() {
        // Identify the element, and give it a class name
        document.getElementById('chat-indicator').className = 'green-icon';
    });
    olark('api.chat.onOperatorsAway', function() {
        // Identify the element, and give it a class name
        document.getElementById('chat-indicator').className = 'red-icon';
    });
    */

</script>
<div class="modal fade" tabindex="-1" role="dialog" id="redeemPoints">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="color: #ffffff; background-color: #dd0101;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Redeem Points</h4>
            </div>
            <form method="post" id="redeemForm" action="../wp-admin/admin.php?page=user-panel">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="mode[]" value="Flight" checked> Flight</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="mode[]" value="Hotel"> Hotel</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="mode[]" value="Car"> Car</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="radio">
                                    <label><input type="radio" name="type" value="Round-Trip" checked> Round-Trip</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="type" value="One-way"> One-way</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="type" value="Multi-city"> Multi-city</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="from">From</label> <small>(city name or airport)</small>
                                <input type="text" class="form-control" id="from" name="from">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="include_from" value="Yes" /> Include airports within 80 miles</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="to">To</label> <small>(city name or airport)</small>
                                <input type="text" class="form-control" id="to" name="to">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="include_to" value="Yes" /> Include airports within 80 miles</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="leave">Leave</label>
                                <input type="text" class="form-control datepicker" id="leave" name="leave" placeholder="mm/dd/yy">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="return">Return</label>
                                <input type="text" class="form-control datepicker" id="return" name="return" placeholder="mm/dd/yy">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label><input type="checkbox" name="search_3" value="Yes"> Search 3 days before and after</label>
                        </div>
                        <div class="col-lg-6">
                            <label><input type="checkbox" name="prefer" value="Yes" /> Prefer non-stop</label>
                        </div>
                    </div>

                    <br/>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="adults">Adults (18 - 64)</label>
                                <select name="adults">
                                    <?php for ($i = 1; $i < 10; $i++) echo "<option value=\"$i\">$i</option>"; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="children">Children (0 - 17)</label>
                                <select name="children">
                                    <?php for ($i = 0; $i < 10; $i++) echo "<option value=\"$i\">$i</option>"; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="seniors">Seniors (65+)</label>
                                <select name="seniors">
                                    <?php for ($i = 0; $i < 10; $i++) echo "<option value=\"$i\">$i</option>"; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="fakeSubmit">
                        <div class="collapse collapseConfirmation in" aria-expanded="true">
                            <button type="button" style="font-family: 'Open Sans', sans-serif !important" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" style="font-family: 'Open Sans', sans-serif !important;background-color: rgb(10, 166, 153);" data-toggle="collapse" data-target=".collapseConfirmation"  class="btn btn-warning">Next</button>
                        </div>
                        <div id="conformationBox" class="collapse collapseConfirmation">
                            <h4>Are you sure you want to place this request?</h4>
                            <button type="button" style="font-family: 'Open Sans', sans-serif !important" class="btn btn-default" data-toggle="collapse" data-target=".collapseConfirmation">Cancel</button>
                            <input type="submit" style="font-family: 'Open Sans', sans-serif !important;background-color: #dd0101;" value="Finalize Request" class="btn btn-danger">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--<div id="chat-indicator">Live chat</div>-->

<div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Notification</h4>
            </div>
            <div class="modal-body"> </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="font-family: 'Open Sans', sans-serif !important" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">

    /* Operators available */
    .green-icon {
        background-color: green;
    }

    /* Operators offline */
    .red-icon {
        background-color: red;
    }

    div#olark_tab{
        position: fixed;
        left: 0;
        bottom:40%;
        z-index:5000;
    }

    #olark_tab div{
        height: 150px;
        width: 150px;
        float: left;
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
    }

    #olark_tab a{
        /*Edit these to change the look of your tab*/
        background-color: black;
        color: white;
        font: bold 18px "century gothic";
        height: 20px;
        padding: 6px;
        border: 2px solid #363636;
        display: block;
        text-decoration: none;
        text-align: center;
        width: auto;
        -webkit-border-bottom-right-radius:9px;
        -webkit-border-bottom-left-radius:9px;
        -moz-border-radius-bottomleft:9px;
        -moz-border-radius-bottomright:9px;
        border-top-style: none;
        border-top-width: 0;
    }

    #olark_tab a:hover{
        background-color: white;
        color: black;
    }
</style>

<!--REWARDS-->
<script>
    function redeem(){
        $('#redeemPoints').modal('show');
    }
    $(document).ready(function()
    {
        $(document).on('hidden.bs.modal', '.modal', function () {
          $(this).removeData('bs.modal');
          if($('#conformationBox').hasClass("in"))
          {
            $('.collapseConfirmation').collapse('toggle');
          }
        });
    });
    
</script>
<!--OLARK-->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
        f[z]=function(){
            (a.s=a.s||[]).push(arguments)};var a=f[z]._={
        },q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
            f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
            0:+new Date};a.P=function(u){
            a.p[u]=new Date-a.p[0]};function s(){
            a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
            hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
            return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
            b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
            b.contentWindow[g].open()}catch(w){
            c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
            var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
            b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
        loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
    /* custom configuration goes here (www.olark.com/documentation) */
    olark.identify('1998-131-10-8214');/*]]>*/</script><noscript><a href="https://www.olark.com/site/1998-131-10-8214/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>

<!-- Loading Scripts -->
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/Chart.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/chartData.js"></script>
<script src="js/main.js"></script>
<script src="js/filer.min.js"></script>
<script src="js/custom.js"></script>