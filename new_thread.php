<!DOCTYPE html>
<html>
<head>

    <title>Poast | New Thread</title>
    <?php include "file_include.php" ?>

</head>
<body>

    <?php include "header_include.php" ?>

    <section id="new_thread">

    <div class="container12">

            <div class="column12">

                <div class="column3"><br></div>

                <div class="column6">

                    <div class="profile_header">
                        <p>Start a new thread</p>
                    </div>

                    <div class="profile_content">
                        <form class="new-thread-box" method="post" action="thread_view.php">

                            <div class="input_wrapper">
                                <label for="">title</label>
                                <input type="text" name="title">
                            </div>

                            <div class="input_wrapper">
                                <label for="">message</label>
                                <textarea class="textarea" rows="4" cols="50" name="text"></textarea>
                            </div>

                            <div class="input_wrapper">
                                <label for="">reach</label>
                                <select class="radius-selector" name="radius">
                                    <option value=".5">.5 miles</option>
                                    <option value="3">3 mile</option>
                                    <option value="5">5 miles</option>
                                </select>
                            </div>

                            <input type="hidden" name="long" id="long" value="0"/>
                            <input type="hidden" name="lat" id="lat" value="0"/>
                            <input type="hidden" name="new" value="1" />
                            <input class="button right" type="submit" value="create">

                        </form>
                    </div>

                    <div class="spacer"></div>

                </div>

            </div>
    </div>
    </section>

    <script>
        $(document).ready(function() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    $("#long").val(position.coords.longitude);
                    $("#lat").val(position.coords.latitude);
                });
            } else {
            }
        });
    </script>
    <?php include "footer_include.php" ?>
</body>
</html>