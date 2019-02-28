<?php
    function create_timeout()
    {
        $time = $_SERVER['REQUEST_TIME'];

        $timeout_duration = 120;

        if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) 
        {
            logout();
        }

        $_SESSION['LAST_ACTIVITY'] = $time;
    }

    function logout()
    {
        session_unset();
        session_destroy();
        session_start();
    }
?>