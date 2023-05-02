<?php

require '../vendor/autoload.php';

$pinlol = '69420';

// If sending and authed
if (isset($_POST['submit']) && $_REQUEST['PIN'] === $pinlol) {
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
    if ($_FILES["fileToUpload"]["size"] > 10485760) {
        echo "Sorry, your file is too large. (10MB max)";
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
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFileFull)) {
        $system->add($targetFile);
        header('Location: https://skux.life/');
        exit;
    } else {
        echo 'Sorry, there was an error uploading your file.';
        return;
    }
} else if (!empty($_REQUEST['PIN']) && $_REQUEST['PIN'] !== $pinlol) {
    echo '<h1 style="color:white">Invalid pin lol</h1>';
}
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
        <div class="uploadform">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Input PIN: <input type="text" name="PIN" style="width:60px"/><br/><br/>
                
                Select image to upload:<br/><br/>
                <input type="file" name="fileToUpload" id="fileToUpload"><br/><br/>
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
    </body>
</html>