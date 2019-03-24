<?php
    require_once "requires/website.php";

    session_start();
    session_unset();
    session_destroy();
    session_start();

    if(empty($_GET["id"]))
    {
        header("Location: index");
    }
    else
    {
        $_SESSION["QUIZ_ID"] = $_GET["id"];
    }

    $site = new Website("quiz");

    $site->placeHead();

    $site->placeHeader();

    $site->placeFooter(); 
?>    