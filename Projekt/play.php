<?php
    require_once "requires/builder.php";

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

    $builder = new Builder("quiz");

    $builder->placeHead();

    $builder->placeHeader();

    $builder->create_play_page();

    $builder->placeFooter(); 
?>    