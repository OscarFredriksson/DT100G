<?php
    require "requires/quiz.php";

    if(empty($_GET["id"]))
    {
        header("Location: index");
    }
    else
    {
        $site = new Website();
        $quiz = new Quiz($_GET["id"]);
    }

    $site->placeHead();

    $site->placeHeader();

    $quiz->placeQuestion();

    $quiz->placeAlternatives();

    $site->placeFooter(); 
?>


    