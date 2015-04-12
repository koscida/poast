<script type="text/javascript">
    $("document").ready(function(){

        prep_ajax();

        function prep_ajax() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    do_ajax(position.coords.latitude, position.coords.longitude);
                });
            } else { }
        }


        function do_ajax(lat, long) {
            var data = {
                lat: lat,
                long: long
            };
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "ajax_get_local_poasts.php", //Relative or absolute path to response.php file
                data: data,
                success: function(response) {
                    console.log(response);
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

<div class="threads_content column12 outer">
    <div id="gen_posts" ><img src="images/loading_spinner.gif" /></div>


<div class="threads_load_more">
    <img class="load" src="images/load_dots.png">

</div>

</div>