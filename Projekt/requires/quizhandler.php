<?php
    require_once "quiz.php";
    
    session_start();

    if(empty($_SESSION['quiz']))
    {
        $quiz = new Quiz($_SESSION["QUIZ_ID"]);
    }
    else
    {
        $quiz = $_SESSION['quiz'];
        $quiz->reconnect_to_DB();
    }

    if(!empty($_REQUEST["request"]))
    {
        switch($_REQUEST["request"])
        {
            case "load question":       $quiz->placeQuestion();
                                        break;
            case "load answers":        $quiz->placeAlternatives();
                                        break;
            case "get nr of questions": echo $quiz->getNumberOfQuestions();
                                        break;
            case "next question":       $quiz->nextQuestion();
                                        break;
            case "is last question":    echo $quiz->isLastQuestion();
                                        break;
            case "check answer":        echo $quiz->checkAnswer($_GET["answer_id"]);
                                        break;
            case "add answer":          $quiz->addAnswer($_GET["text"], $_GET["is_correct"]); 
                                        break;
            case "get questions left":  echo $quiz->getQuestionsLeft();
                                        break;
            case "is finished":         echo $quiz->isFinished();   
        }
    }
    
    $_SESSION['quiz'] = $quiz;
?>