<!DOCTYPE html>
<html>
<head>

    <title>Poast | Home</title>
    <?php include "file_include.php" ?>

</head>
<body>

    <?php include "header_include.php" ?>

    <section id="home" class="container12">

        <div class="column3" id="profile">
            <?php include "home_profile_module.php" ?>
        </div>

        <div class="column9">
            <div id="static_thread" style="display: none;">
                <?php include "partial_static_thread.php" ?>
            </div>
            <div id="generated_thread">
                <?php include "partial_generated_threads.php" ?>
            </div>
        <div>



    </section>

    <?php include "footer_include.php" ?>

    <script>
    </script>

</body>
</html>