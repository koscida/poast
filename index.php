<!DOCTYPE html>
<html>
<head>

    <title>Poast | Home</title>
    <?php include "file_include.php" ?>

</head>
<body>

    <?php include "header_include.php" ?>
    <!-- <?php include "footer_include.php" ?> -->

    <section id="home" class="container12">
        <div class="thirtypadding"></div>
        <div class="column6" profile" id="profile">
            <?php include "home_profile_module.php" ?>
        </div>
        <div class="column6 staticfeed" id="static_thread">
            <?php include "partial_static_thread.php" ?>
        </div>
        <br>
        <div class="column9 dynamicfeed" id="generated_thread">
            <?php include "partial_generated_threads.php" ?>
        </div>

    </section>
    <div class="fiftypadding"></div>
    <div class="fiftypadding"></div>
    <div class="fiftypadding"></div>
</body>
</html>