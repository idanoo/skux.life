<?php

require '../vendor/autoload.php';

// Boot settings
$system = new Skuxlife\System();
$photos = $system->getPhotos(48);

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Skux.Life</title>
        <link rel="stylesheet" href="static/style.css">
        <link rel="stylesheet" href="static/lightbox.min.css" />
    </head>
    <body>
        <script src="static/lightbox-plus-jquery.min.js" async></script>
        <div class="logo">
            <img class="logoimage" src="images/logo.png" alt="Skux.Life logo" />
        </div>
        <div class="photos">
            <?php
                foreach ($photos as $photo) {
                    echo '<div class="photo">'
                      . '<a data-lightbox="image" href="uploads/' . $photo . '" />'
                      . '<img class="photoimg" src="uploads/' . $photo . '" /></a></div>';
                }
            ?>
        </div>
        <div class="footer">
            <p class="evenlessdark">Copyright retained by the original photographer unless specified.</p>
            <a class="footertext" href="upload.php">Upload</a>
        </div>
        <script>
            // I hate JS.
            var interval = setInterval(function() {
                if (typeof lightbox === 'object') {
                    lightbox.option({
                        'resizeDuration': 250,
                        'imageFadeDuration': 200,
                    })
                    clearInterval(interval);
                }
            }, 100);
        </script>
    </body>
</html>