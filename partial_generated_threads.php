<form style="display: none;" id="ajax_form">
    <input type="hidden" name="lat" id="lat"/>
    <input type="hiddem" name="long" id="long"/>
</form>


<script type="text/javascript">
    $("document").ready(function(){

        //setInterval(prep_ajax, 120000);
        prep_ajax();

        function prep_ajax() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    $("#lat").val(position.coords.latitude);
                    $("#long").val(position.coords.longitude);
                });
                do_ajax();
            } else { }
        }


        function do_ajax() {
            var data = {};
            data = $("#ajax_form").serialize() + "&" + $.param(data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "ajax_get_local_poasts.php", //Relative or absolute path to response.php file
                data: data,
                success: function(response) {
                    //console.log(response);
                    $("#gen_posts").html(response);
                    console.log("success");
                }
            });
        }
    });
</script>


<div id="return"></div>


<div class="threads_header column12 outer">
    <p>Local Toasts: <span>Boulder</span></p>
</div>

<div id="gen_posts"><img src="images/loading_spinner.gif" /></div>


<div class="threads_load_more">
    <img class="load" src="images/load_dots.png">

</div>

