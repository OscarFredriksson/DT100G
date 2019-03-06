<?php 
    function check_login($username, $password)
    {
        $correct_username = "oscar";
        $correct_password = "asdasd";

        if($username === $correct_username && $password === $correct_password)  //Om både användarnamnet och lösenordet är korrekt
        {
            $_SESSION["LOGGED_IN"] = true;  //Sätt att sessionen är inloggad
            header("Location: index.php");  //Skicka vidare användaren till index.php
        } 
        else if(strlen($username) == 0) //Om användaren inte fyllt i ett användarnamn
        {
            echo '<script> alert("Du måste fylla i ett användarnamn"); </script>';  //Använd alert-box för att informera användaren
        }
        else if(strlen($password) == 0) //Om användaren inte fyllt i ett lösenord
        {
            echo '<script> alert("Du måste fylla i ett lösenord"); </script>';  //Använd alert-box för att informera användaren
        }
        else    //Annars är både användarnamn och lösenord ifyllt, men de är felaktiga
        {
            echo '<script> alert("Fel användarnamn eller lösenord"); </script>';    //Använd alert-box för att informera användaren
        }
    }

    function check_if_logged_in()   //Kolla om användaren är inloggad
    {
        if($_SESSION["LOGGED_IN"] == false)     //Om inte, skicka användaren till inloggningssidan
        {
            header("Location: login.php");
        }
    }
    
    function new_session()  //Starta en ny session som alltid kommer bli ny, även om det redan fanns en
    {
        session_start();    //Starta en session utifall det inte finns en (finns det ingen kommer nästa rad misslyckas)
        
        session_unset();    //Om det redan fanns en måste användaren loggas ut, förstör sessionen
        session_destroy();
        
        session_start();    //Starta en ny session
    }

    function check_timeout()    //Kolla om 
    {
        $timeout_duration = 900;    //15 min

        $time = $_SERVER['REQUEST_TIME'];   //Spara nuvarande tid

        if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration)  //Om användaren har varit inaktiv längre än den bestämda timeout-tiden
        {
            //Använd javascript för att visa en alert-box med info, och sedan skicka användaren vidare till login.php
            echo "<script> 
                alert('Du har blivit utloggad pågrund av inaktivitet');     
                window.location.href='login.php';
            </script>";
            
        }

        $_SESSION['LAST_ACTIVITY'] = $time; //Spara nuvarande tid som sist användaren var aktiv 
    }

    function check_session()    //kolla om sessionen är inloggad och inte har nått sin timeout-tid
    {
        session_start();

        check_if_logged_in();
        
        check_timeout();
    }
?>
