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
        <div class="column7" id="static_thread">
            <?php include "partial_static_thread.php" ?>
        </div>
        <br>
        <div class="column6" id="generated_thread">
            <?php include "partial_generated_threads.php" ?>
        </div>

    </section>
    <div class="fiftypadding"></div>
    <div class="fiftypadding"></div>
    <div class="fiftypadding"></div>
</body>
</html>