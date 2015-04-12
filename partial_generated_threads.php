<script type="text/javascript">
    $("document").ready(function(){

        //prep_ajax();
        $("#local").click(function(){
            prep_ajax(0.005);
            $("#h").html(0.005);
        });
        $("#hyper").click(function(){
            prep_ajax(0.001);
            $("#h").html(0.001);
        });

        function prep_ajax(loc) {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var loc = $("#h").html();
                    do_ajax(position.coords.latitude, position.coords.longitude, loc);
                });
            } else { }
        }


        function do_ajax(lat, long, loc) {
            console.log("in do ajax");
            console.log(loc);
            var data = {
                lat: lat,
                long: long,
                loc: loc
            };
            $.ajax({
                type: "GET",
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

<div id="h" style="display: none">0.001</div>

<div class="threads_header column12 outer">
    <p>Local Toasts: <span>Boulder</span></p>

    <button id="hyper" class="button right">Hyper Local</button>
    <button id="local" class="button right">Local</button>
</div>

<div class="threads_content column12 outer">
    <div id="gen_posts" ><img src="images/loading_spinner.gif" /></div>


<div class="threads_load_more">
    <img class="load" src="images/load_dots.png">

</div>

</div>