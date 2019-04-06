/*
    Denna fil innehåller javascript-koden för index.php sidan. 

    Den innehåller bara en funktion vars funktion är att starta ett quiz när "spela"-knappen
    för ett quiz trycks på.

    All kod är skriven av Oscar Fredriksson 
*/

function playButtonClicked(obj) //När "spela"-knappen för ett quiz trycks
{
    /*
    * Gå till spela-sidan för det quizzet, dess ID sparas i html-elementets ID-attribut
    * som sedan hämtas och läggs i URL-en så PHP-kod sedan kan hämta ID-t från URL-en.
    */

    window.location.href = "play.php?id=" + obj.id; 
}

