<?php
    require "requires/builder.php";
    require_once "requires/quiz.php";

    session_start();

    $builder = new Builder("result");

    $builder->placeHead();

    $builder->placeHeader();

    if(empty($_SESSION['quiz']) or !$_SESSION['quiz']->isFinished())    
    {
        Header("Location: index");
    }
    else                           
    {
        $quiz = $_SESSION['quiz'];
    }

    $quiz->createResultPage();

    $builder->create_result_popup_box();

    $builder->placeFooter();
?>