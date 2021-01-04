<?php
    session_start();

    if(!isset($_SESSION['isRegistrationCorrectly']))
    {
        header('Location: index.php');
        exit();
    }
    else 
    {
        unset($_SESSION['isRegistrationCorrectly']);
    }
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Kalendarz</title>
    </head>

    <body>

        Dziękujemy za rejestrację w serwisie. Możesz już zalogować się na swoje konto<br /><br />

        <a href="index.php">Zaloguj się na swoje konto</a>
        <br /><br />

    </body>
</html>