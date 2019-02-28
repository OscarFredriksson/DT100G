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
        else
        {
            echo "Fel användarnamn eller lösenord";
        }
    }

    function check_if_logged_in()
    {
        if($_SESSION["LOGGED_IN"] == false) 
        {
            header("Location: login.php");
        }
    }
    
    function logout()
    {
        session_unset();
        session_destroy();
        session_start();
    }

    function check_timeout()
    {

        $timeout_duration = 5;

        $time = $_SERVER['REQUEST_TIME'];

        if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) 
        {
            logout();
        }

        $_SESSION['LAST_ACTIVITY'] = $time;
    }

    function check_session()
    {
        session_start();
        
        check_timeout();

        check_if_logged_in();

    }
?>
