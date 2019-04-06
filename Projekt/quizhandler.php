<?php
    /*
    *   Denna fil hanterar ajax-förfrågningar från javascript-filen när ett quiz spelas. 
    *
    *   Här skapas en instans av klassen Quiz och sedan görs ajax förfrågningar till denna 
    *   fil med vilka operationer som ska utföras på Quiz-objektet. 
    *
    *   En session används för att hela tiden spara undan quiz-objektet så att det 
    *   sedan kan hämtas igen när näst ajax förfrågan körs.   
    *
    *   All kod är skriven av Oscar Fredriksson   
    */

    require_once "requires/quiz.php";

    session_start();

    if(empty($_SESSION['quiz']))    //Om sessionen är tom, skapa ett nytt quiz-objekt
    {
        $quiz = new Quiz($_SESSION["QUIZ_ID"]);
    }
    else    
    {

        //Hämta quizzet från sessionen och återanslut till dess databas
        $quiz = $_SESSION['quiz'];
        $quiz->reconnect_to_DB();    
    }

    if(!empty($_REQUEST["request"]))    //Om det finns en request
    {
        //Kör motsvarande funktion för requesten
        switch($_REQUEST["request"])
        {
            case "get question":        $quiz->placeQuestion();
                                        break;
            case "get alternatives":    $quiz->placeAlternatives();
                                        break;
            case "get nr of questions": echo $quiz->getNumberOfQuestions();
                                        break;
            case "next question":       $quiz->nextQuestion();
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