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

                <div class="new-thread-box">

                    <p class="new-thread-page-title">
                    Start a new thread

                    </p>

                    <form class="new-thread-form">
                        <h1 class="subtitle">
                            thread title
                        </h1>
                        <input class="new-thread-title-field" type="text" name="firstname">
                        <br><br>
                        <h1 class="subtitle">
                            thread text
                        </h1>
                        <textarea class="new-thread-text-area" rows="4" cols="50">

                        </textarea>

                        <input class="new-thread-button new-thread-create-button" type="submit" value="create">
                    </form>

                </div>

            </div>
    </div>
    </section>
</body>
</html>