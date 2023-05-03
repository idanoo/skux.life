<?php

require '../vendor/autoload.php';

session_start();

// Boot settings
$system = new Skuxlife\System();
$photos = $system->getPhotos(50);
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
        <div class="navbar">
            <?= Skuxlife\User::loggedIn()
                ? '<a class="navtext" href="' . Skuxlife\System::getURL('/profile') . '">Upload</a>'
                    . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="navtext" href="' . Skuxlife\System::getURL('/logout') . '">Logout (' . $_SESSION['username'] . ')</a>'
                : '<a class="navtext" href="' . Skuxlife\System::getURL('/login') . '">Login</a>'; ?>
        </div>
        <div class="photos">
            <?php
                foreach ($photos as $photo) {
                    echo '<div class="photo">'
                      . '<a data-lightbox="image" href="uploads/' . $photo . '" />'
                      . '<img class="photoimg" src="uploads/' . str_replace('.', '-thumb.', $photo) . '" />'
                      . '</a>'
                      . '</div>';
                }
            ?>
        </div>
        <div class="footer">
            <p class="evenlessdark">
                Skux Life is a site for a small collective of photographers wanting a place to show images away from mainstream platforms.<br/></br>
                Uploads are displayed anonymously on the site and are not to be reproduced without permission.</br>
                Copyright is retained by the original photographers.
            </p>
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