<?php
    require_once "requires/builder.php";
    require_once "requires/database/database.php";

    session_start();

    if(empty($_GET["id"]))
    {
        header("Location: index");
    }
    else
    {        
        $_SESSION["QUIZ_ID"] = $_GET["id"];

        $database = new Database();

        if(!$database->quiz_exists($_SESSION["QUIZ_ID"]))   header("Location: index");  
    }

    $builder = new Builder("quiz", $database->get_quiz_title( $_SESSION["QUIZ_ID"]));

    $builder->placeHead();

    $builder->placeHeader();

    $builder->create_play_page();

    $builder->placeFooter(); 
?>    