<?php

require '../vendor/autoload.php';

session_start();

// Handle logout/login/register
if (!empty($_REQUEST['logout'])) {
    session_destroy();
    header('Location: https://skux.life/');
} else if (!empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
    if (!empty($_REQUEST['register'])) {
        $success = Skuxlife\User::register($_REQUEST['username'], $_REQUEST['password']);
        if ($success) {
            header('Location: https://skux.life/');
        } else {
            echo '<h1>There was an error creating your account :3</h1>';
        }
    } else if (!empty($_REQUEST['login'])) {
        $success = Skuxlife\User::login($_REQUEST['username'], $_REQUEST['password']);
        if ($success) {
            header('Location: https://skux.life/');
        } else {
            echo '<h1>There was an error logging in to your account :3</h1>';
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
        <div class="uploadform">
            <form action="/login.php" method="post">
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
                            <input type="submit" value="Register" name="register">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>