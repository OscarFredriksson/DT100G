<?php
    require "requires/builder.php";
    require_once "requires/quiz.php";

    session_start();

    if(empty($_SESSION['quiz']) or !$_SESSION['quiz']->isFinished())    
    {
        Header("Location: index");
    }
    else                           
    {
        $quiz = $_SESSION['quiz'];
        session_unset();
        session_destroy();

        $quiz->reconnect_to_DB();

        $builder = new Builder("result", $quiz->getTitle());

        $builder->placeHead();
        $builder->placeHeader();
        $builder->placePageStart();

        $quiz->placeResultBoxes();

        $builder->placePageEnd();

        $builder->create_result_popup_box();

        $builder->placeFooter();
    }

?>