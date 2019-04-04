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

    require_once "requires/builder.php";            //Inkludera hemsidebyggaren för att kunna skapa ett objekt av denna
    require_once "requires/database/database.php";  //Inkludera databas-klassen för att kunna skapa ett objekt av denna

    /*
    *   För att hantera ajax-förfrågningarna från javascript-filen används en annan fil (quizhander.php).
    *   Därför används sessioner för att lagra quizzets ID så den sidan vet vilket quiz det handlar om
    */
    session_start();

    if(empty($_GET["id"]))  //Om quiz-IDt är tomt är nått fel, gå till index sidan
    {
        header("Location: index");
    }
    else    //Annars finns det ett ID att hämta
    {        
        $_SESSION["QUIZ_ID"] = $_GET["id"]; //Hämta IDt och lagra det i sessionen

        $database = new Database(); //Skapa ett nytt databas-objekt

        //Kolla om det finns ett quiz med det givna IDt, om inte, gå till index-sidan
        if(!$database->quiz_exists($_SESSION["QUIZ_ID"]))   header("Location: index");  
    }

    //Skapa en ny hemsidebyggare för quiz-sidan, skicka in quizzets titel för att kunna placera denna i headern
    $builder = new Builder("play", $database->get_quiz_title($_SESSION["QUIZ_ID"]));

    $builder->placeHead();          //Be byggaren placera ut hemsidans <head> där bland annat CSS filen inkluderas
    $builder->placeHeader();        //Be byggaren placera ut hemsidans header med navigeringslänkar
    $builder->placePageStart();     //Be byggaren placera ut starten på hemsidan så denna sedan kan fyllas med quiz-boxarna 
 
    $builder->create_play_page();   //Bygg grunden för spel-sidan, resten fylls senare av javascript

    $builder->placePageEnd();   //Placera ut hemsidans slut på innehållet
    $builder->placeFooter();    //Placera ut sidans footer
?>    