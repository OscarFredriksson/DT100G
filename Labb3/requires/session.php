<?php 
    function check_login($username, $password)
    {
        $correct_username = "oscar";
        $correct_password = "7892457348";

        if($username === $correct_username && $password === $correct_password)
        {
            $_SESSION["LOGGED_IN"] = true;
            header("Location: index.php");
        } 
        else if(strlen($username) == 0)
        {
            echo '<script> alert("Du måste fylla i ett användarnamn"); </script>';
        }
        else if(strlen($password) == 0)
        {
            echo '<script> alert("Du måste fylla i ett lösenord"); </script>';
        }
        else
        {
            echo '<script> alert("Fel användarnamn eller lösenord"); </script>';
        }
    }

    function check_if_logged_in()
    {
        if($_SESSION["LOGGED_IN"] == false) 
        {
            header("Location: login.php");
        }
    }
    
    function new_session()
    {
        session_start();
        session_unset();
        session_destroy();
        session_start();
    }

    function check_timeout()
    {
        $timeout_duration = 900;    //15 min

        $time = $_SERVER['REQUEST_TIME'];

        if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) 
        {
            echo "<script> 
                alert('Du har blivit utloggad pågrund av inaktivitet'); 
                window.location.href='login.php';
            </script>";
            
        }

        $_SESSION['LAST_ACTIVITY'] = $time;
    }

    function check_session()
    {
        session_start();

        check_if_logged_in();
        
        check_timeout();
    }
?>
