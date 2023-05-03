<?php

require '../vendor/autoload.php';

session_start();

if (!Skuxlife\User::loggedIn()) {
    header('Location: ' . Skuxlife\System::getURL('/login'));
}

// If sending and authed
if (isset($_POST['submit'])) {
    // Boot to create DB record for upload
    $system = new Skuxlife\System();
    $hash = $system->generateUid();

    // Get file info 
    $mimeType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
    $targetFile = $hash . '.'. $mimeType;
    $targetFileFull = 'uploads/' . $targetFile;
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image. wtf.";
        return;
    }

    // Check if file already exists
    if (file_exists($targetFileFull)) {
        echo "Sorry, file already exists.";
        return;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 52428800) {
        echo "Sorry, your file is too large.";
        return;
    }
    
    // Allow certain file formats
    if (
        $mimeType != 'jpg'
        && $mimeType != 'png'
        && $mimeType != 'jpeg'
        && $mimeType != 'gif' ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return;
    }
    
    // Compress
    $img = new Imagick($_FILES["fileToUpload"]["tmp_name"]);
    $img->setImageCompression(Imagick::COMPRESSION_JPEG);
    $img->setImageCompressionQuality(80);
    $img->setImageFormat("jpg");

    // Strip metadata
    $img->stripImage();
    $img->writeImage($targetFileFull);

    // Generate thumb
    $img->scaleImage(250, 250, Imagick::FILTER_LANCZOS, 1);
    $img->writeImage('uploads/' . $hash . '-thumb.'. $mimeType);
    
    // Add to DB
    $system->add($targetFile);

    // Redirect!!
    header('Location: ' . Skuxlife\System::getURL());
    exit;
} else if (!empty($_REQUEST['delete'])) {
    Skuxlife\System::delete($_REQUEST['delete']);
}
$system = new Skuxlife\System();
$photos = $system->getPhotos(50, true);
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Skux.Life</title>
        <link rel="stylesheet" href="static/style.css">
    </head>
    <body>
        <div class="logo">
            <img class="logoimage" src="images/logo.png" alt="Skux.Life logo" />
        </div>
        <div class="navbar">
            <a class="navtext" href="<?= Skuxlife\System::getURL('/') ?>">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="navtext" href="<?= Skuxlife\System::getURL('/logout') ?>">Logout</a>
        </div>
        <div class="profile">
            <div class="profile-left">
                <div class="userphotos">
                    <?php
                        foreach ($photos as $photo) {
                            ?>
                            <div class="photo">
                                    <img class="photoimg" onclick="if (confirm('Do you want to delete this image??')) {
                                        window.location.href = '<?= Skuxlife\System::getURL('/profile') ?>?delete=<?= $photo ?>';
                                    }" src="uploads/<?= str_replace('.', '-thumb.', $photo) ?>" />
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="profile-right">
                <div class="uploadform">
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        Select image to upload:<br/><br/>
                        <input type="file" name="fileToUpload" id="fileToUpload"><br/><br/>
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>