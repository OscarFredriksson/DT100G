<?php
    /*
    *   Detta är index-sidan för webbplatsen, alltså webbplatsens startsida. 
    *
    *   Här hämtas alla quiz från databasen och presenteras på startsidan med
    *   knappar för att spela quizzen. 
    *
    *   All kod är skriven av Oscar Fredriksson   
    */

    require_once "requires/builder.php";            //Inkludera hemsidebyggaren för att kunna skapa ett objekt av denna
    require_once "requires/database/database.php";  //Inkludera databas-klassen för att kunna skapa ett objekt av denna

    /*
    *   Sessioner används när ett quiz spelas, utifall användaren går till
    *   startsidan utan att avsluta quizzet "korrekt" se till att återställa
    *   sessionen.
    */
    session_start();
    session_unset();
    session_destroy();
    
    $builder = new Builder("index");    //Skapa ett nytt objekt av hemsidebyggaren

    $builder->placeHead();          //Be byggaren placera ut hemsidans <head> där bland annat CSS filen inkluderas
    $builder->placeHeader();        //Be byggaren placera ut hemsidans header med navigeringslänkar
    $builder->placePageStart();     //Be byggaren placera ut starten på hemsidan så denna sedan kan fyllas med quiz-boxarna 
 
    $database = new Database();     //Skapa ett nytt objekt av databas-klassen 
    
    $quizzes = $database->get_all_quizzes();    //Hämta alla quiz-id från databasen

    //Gå igenom alla quiz som hämtades från databasen
    foreach($quizzes as $quiz_ID)
    {
        $title = $database->get_quiz_title($quiz_ID);           //Hämta quizzets titel från databasen
        $descr = $database->get_quiz_descr($quiz_ID);           //Hämta quizzets beskrivningstext från database
        $builder->create_quiz_box($quiz_ID, $title, $descr);    //Bygg en box för quizzet
    } 

    $builder->placePageEnd();   //Placera ut slutet på innehållet
    $builder->placeFooter();    //Placera ut sidans footer
?>