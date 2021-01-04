<?php

    session_start();

    if (isset($_POST['nick']))
    {
        //Udana walidacja
        $correct = true;
        //Sprawdż poprawność nicka
        $nick = $_POST['nick'];
        //Sprawdzenie długości nicka
        if ((strlen($nick)<3) || (strlen($nick)>20))
        {
            $correct = false;
            $_SESSION['error_nick'] = "Nick musi posiadać od 3 do 20 znaków";
        }

        if (ctype_alnum($nick) == false)
        {
            $correct = false;
            $_SESSION['error_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
        }

        //Sprawdż poprawność hasła
        $password = $_POST['password'];
        $passwordRepeated = $_POST['passwordRepeated'];

        if ((strlen($password) < 8) || strlen($passwordRepeated) > 20)
        {
            $correct = false;
            $_SESSION['error_password'] = "Hasło musi posiadać od 8 do 20 znaków";
        }

        if ($password != $passwordRepeated)
        {
            $correct = false;
            $_SESSION['error_password'] = "Podane hasła nie są identyczne";
        }

        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try 
        {
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if ($connection->connect_errno != 0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else 
            {
                //Czy email juz istnieje
                /* $rezultat = $connection-> query("SELECT id FROM uzytkownicy WHERE email='$email'");

                if (!$rezultat) throw new Exception($connection->error);

                $ile_takich_maili = $rezultat->num_rows;
                if ($ile_takich_maili>0)
                {
                    $wszystko_OK = false;
                    $_SESSION['e_email'] = "Istnieje już konto przypisane do takiego adresu email";
                } */

                //Czy nick jest juz zarezerowowany
                $result = $connection-> query("SELECT id FROM users WHERE nickname='$nick'");

                if (!$result) throw new Exception($connection->error);

                $isNicknameInDatabase = $result->num_rows;
                if ($isNicknameInDatabase>0)
                {
                    $correct = false;
                    $_SESSION['error_nick'] = "Istnieje już osoba o takim nicku. Wybierz inny.";
                }

                if ($correct == true)
                {
                    //Hurra, wszystko ok, dodajemy gracza do bazy
                    if ($connection->query("INSERT INTO users VALUES(NULL, '$nick', '$pass_hash')"))
                    {
                        $_SESSION['isRegistrationCorrectly'] = true;
                        header('Location: welcome.php');
                    } 
                    else 
                    {
                        throw new Exception($connection->error);
                    }
                    
                }

                $connection->close();
            }
        }
        catch(Exception $e)
        {
            echo "Błąd serwera. Przepraszamy za niedogodności.";
        }
    }

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Kalendarz - rejestracja</title>

        <link rel="stylesheet" href="style.css" />

        <style>
        .error {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        </style>
    </head>

    <body>
        <form class="authForm" method="post">
            
            Nickname: <br /><input type="text" name="nick" /><br />
            <?php 
                if (isset($_SESSION['error_nick']))
                {
                    echo '<div class=error>'.$_SESSION['error_nick'].'</div>';
                    unset($_SESSION['error_nick']);
                }
            ?>

            Twoje hasło: <br /><input type="password" name="password" /><br />

            <?php 
                if (isset($_SESSION['error_password']))
                {
                    echo '<div class=error>'.$_SESSION['error_password'].'</div>';
                    unset($_SESSION['error_password']);
                }
            ?>

            Powtórz hasło: <br /><input type="password" name="passwordRepeated" /> <br /><br />

            <input type="submit" value="Zarejestruj się" />
        </form>


    </body>
</html>