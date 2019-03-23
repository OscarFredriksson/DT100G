<?php
    require_once "quiz.php";
    
    session_start();

    if(empty($_SESSION['quiz']))
    {
        $quiz = new Quiz($_SESSION["QUIZ_ID"]);
        $_SESSION['quiz'] = $quiz;
    }
    else
    {
        $quiz = $_SESSION['quiz'];
    }

    if(!empty($_REQUEST["request"]))
    {
        switch($_REQUEST["request"])
        {
            case "load question":   $quiz->placeQuestion();
                                    break;
            case "next question":   $quiz->nextQuestion();
                                    break;
        }
    }
?>