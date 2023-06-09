<?php

require '../vendor/autoload.php';

session_start();

if (!empty($_REQUEST['login']) && !empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
    $success = Skuxlife\User::login($_REQUEST['username'], $_REQUEST['password']);
    if ($success) {
        header('Location: ' . Skuxlife\System::getURL());
    } else {
        echo '<h1 style="color:white">There was an error logging in to your account :3</h1>';
    }
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
        <div class="logo">
            <img class="logoimage" src="images/logo.png" alt="Skux.Life logo" />
        </div>
        <div class="navbar">
            <a class="navtext" href="<?= Skuxlife\System::getURL('/') ?>">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="navtext" href="<?= Skuxlife\System::getURL('/register') ?>">Register</a>
        </div>
        <div class="loginform">
            <form action="<?= Skuxlife\System::getURL('/login') ?>" method="post">
                <table>
                    <tr>
                        <td>username</td>
                        <td><input name="username"></td>
                    </tr>
                    <tr>
                        <td>password</td>
                        <td><input type="password" name="password"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br/>
                            <input type="submit" value="Login" name="login">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>