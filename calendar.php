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

        <style>
        <?php
            include_once "style.css";
        ?>
        </style>
    </head>

    <body>

        <?php

        echo "<p>Witaj, ".$_SESSION['nickname'].'! [ <a class="link" href="logout.php">Wyloguj się!</a> ]</p>';

        ?>
        
        <div class="pageContent">
            <div class="calendarNotesForm">
                <textarea cols="40" rows="25" class="note">Dodaj swoją notatkę</textarea> 
                <br />
                <input type="button" value="Dodaj notatkę"/>
            </div>

            <div class="calendar-contener"></div>
        <div>
        
    <script src="calendar.js"></script>
    </body>
</html>