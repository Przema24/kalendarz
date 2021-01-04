<?php

    session_start();

    if((!isset($_POST['nickname'])) || !(isset($_POST['password'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";


    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0)
    {
        echo "Error".$connection->connect_errno;
    }
    else 
    {
        $nick = $_POST['nickname'];
        $pass = $_POST['password'];

        $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");


        if ($result = @$connection->query(sprintf("SELECT * FROM users WHERE nickname='%s'",
            mysqli_real_escape_string($connection,$nick))))
        {
            $isUserExist = $result->num_rows;
            if($isUserExist > 0)
            {
                $row = $result->fetch_assoc();

                if (password_verify($pass, $row['password']))
                {
                    $_SESSION['isLogged'] = true;
                    
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['nickname'] = $row['nickname'];


                    unset($_SESSION['error']);
                    $result->free_result();

                    header('Location: calendar.php');
                } else
                {
                    $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
                    header('Location: index.php');
                }
                
            } else
            {
                $_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło</span>';
                header('Location: index.php');
            }
        }

        $connection->close();
    }

?>