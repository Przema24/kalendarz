<?php
    session_start();

    if((isset($_SESSION['isLogged'])) && ($_SESSION['isLogged'] == true))
    {
        header('Location: calendar.php');
        exit();
    }
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Kalendarz</title>

        <link rel="stylesheet" href="style.css" />
    </head>

    <body>

        <a class="link" href="registration.php">Nie masz konta? Zarejestruj się.</a>

        <form class="authForm" action="signIn.php" method="post">
            Nazwa użytkownika: 
            <input type="text" name="nickname" /> 
            Hasło: 
            <input type="password" name="password" /> 
            <?php 
            if (isset($_SESSION['error']))
            {
                echo $_SESSION['error'];
            }
            ?>
            <input type="submit" value="Zaloguj się" />
        </form>

        

    </body>
</html>