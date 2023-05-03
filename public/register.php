<?php

require '../vendor/autoload.php';

session_start();

if (
    !empty($_REQUEST['register'])
    && !empty($_REQUEST['username'])
    && !empty($_REQUEST['password'])
    && !empty($_REQUEST['code'])
) {
    if (!password_verify($_REQUEST['code'], '$2y$10$T4AoNzpPiE/klFkf2irYUep81gLzLBg2KGV48bmWOynYKf9Hsnzn6')) {
        echo '<h1 style="color:white">Invalid referral code</h1>';
    } else {
        $success = Skuxlife\User::register($_REQUEST['username'], $_REQUEST['password']);
        if ($success) {
            header('Location: ' . Skuxlife\System::getURL());
        } else {
            echo '<h1 style="color:white">There was an error registering.. maybe you exist already O_O?</h1>';
        }
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
            <a class="navtext" href="<?= Skuxlife\System::getURL('/login') ?>">Login</a>
        </div>
        <div class="loginform">
            <form action="<?= Skuxlife\System::getURL('/register') ?>" method="post">
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
                        <td>code</td>
                        <td><input name="code"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br/>
                            <input type="submit" value="Register" name="register">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>