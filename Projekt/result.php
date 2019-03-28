<?php
    require "requires/builder.php";
    require_once "requires/quiz.php";

    session_start();

    $builder = new Builder("result");

    $builder->placeHead();

    $builder->placeHeader();

    if(empty($_SESSION['quiz']))    Header("Location: index");
    else                            
    {
        $quiz = $_SESSION['quiz'];
        $quiz->reconnect_to_DB();
    }

    $quiz->createResultPage();

    $builder->create_result_box();

    $builder->placeFooter();
?>