<?php
    /*
    *   Detta är sidan där ett quiz-spelas
    *
    *   Vilket quiz som ska spelas ges från _GET variabeln i URL-en, därför kollas först 
    *   om denna är ett korrekt quiz. Om variablen är tom eller inte är ett korrekt
    *   quiz ID så skickas användaren till index-sidan.
    *
    *   Om ID-t är korrekt byggs grunden för sidan upp, sedan fylls resten av innehållet
    *   med hjälp av ajax-förfrågningar i javascript-filen. 
    *
    *   All kod är skriven av Oscar Fredriksson   
    */

    require "requires/builder.php";     //Inkludera hemsidebyggaren för att kunna skapa ett objekt av denna
    require_once "requires/quiz.php";   //Inkludera quiz-klasseen för att kunna skapa ett objekt av denna

    /*
    *   Sessioner används för att skicka information om quizzet mellan olika php-filer.
    *   I denna fil behövs det för att hämta quiz-objektet från sessionen.
    */
    session_start();


    /*
    *   Om quiz-objektet inte finns, eller om quizzet inte är färdigspelat har nått gått fel, 
    *   gå till index-sidan
    */
    if(empty($_SESSION['quiz']) or !$_SESSION['quiz']->isFinished())    
    {
        Header("Location: index");
    }
    else                          
    {
        $quiz = $_SESSION['quiz'];  //Spara quiz-objektet
        
        //Eftersom quizzet är färdigspelat behövs inte sessionen mer, ta bort den
        session_unset();    
        session_destroy();

        $quiz->reconnect_to_DB();   //Anslut till quizzets databas

        //Skapa en ny hemsidebyggare för sidan, skicka in quizzet titel för att kunna placera denna i headern
        $builder = new Builder("result", $quiz->getTitle());

        $builder->placeHead();          //Be byggaren placera ut hemsidans <head> där bland annat CSS filen inkluderas
        $builder->placeHeader();        //Be byggaren placera ut hemsidans header med navigeringslänkar
        $builder->placePageStart();     //Be byggaren placera ut starten på hemsidan så denna sedan kan fyllas med quiz-boxarna 
 
        $quiz->placeResultBoxes();  //Be quiz-objektet om quizzets resultat

        $builder->placePageEnd();   //Placera ut slutet på innehållet

        /*
        * Placera en popup-box för resultatet, denna är gömd från början, och fylls och visas 
        * med hjälp av javascript när en av frågeknapparna trycks på
        */
        $builder->create_result_popup_box();   

        $builder->placeFooter();    //Placera ut sidans footer
    }

?>