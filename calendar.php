<?php
    session_start();

    if (!isset($_SESSION['isLogged']))
    {
        header('Location: index.php');
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

        <?php

        echo "<p>Witaj, ".$_SESSION['nickname'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';

        ?>

        <form action="#" class="calendarNotesForm">
            <textarea cols="40" rows="25">Dodaj swoją notatkę</textarea>
            <input type="submit" value="Dodaj notatkę"/>
        </form>

        <div class="calendar-contener"></div>

    <script src="calendar.js"></script>
    </body>
</html>