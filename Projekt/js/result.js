/*
*   Denna fil innehåller javascript-koden för result.php sidan. 
*
*   Javascriptets uppgift här är att visa popup-rutan när användaren klickar på en av 
*   knapparna för en fråga. Grunden för en popup-box ligger på HTML-sidan som med hjälp
*   av CSS är dold, när användaren klickar på en av knapparna fylls boxen med infon för den frågan 
*   och visas sen. 
*
*   All kod är skriven av Oscar Fredriksson 
*/

var popup = document.getElementById('popup');   //Spara elementet för popup-boxen

var closeBtn = document.getElementById('close');    //Spara elementet för popup-boxens "stäng"-knapp

closeBtn.onclick = function()   //När "stäng"-knappen klickas
{
    popup.style.display = "none";   //Göm boxen
}

/*
*   Denna funktionen körs när en av knapparna klickas, då skickas texten för frågan samt användarens 
*   svar in till funktionen. Om användaren svarade fel skickas även det rätta svaret med.
*/
function showAnswer(question, answer, correct_answer)
{    
    var content = document.getElementById('popup-content'); //Spara elementet för popup-boxens innehåll

    content.innerHTML = '<h2 class="question">Fråga: ' + question + '</h2>';    //Placera frågans text


    if(typeof correct_answer === 'undefined')   //Om ett korrekt svar inte har skickat med är användarens svar korrekt
    {
        /*
        *   Placera ut text för användarens svar med relevant ikon mm.
        *   escapeHTML funktionen körs för att undvika eventuella HTML-taggar ("<" eller ">")
        *   i svarstexten
        */ 
        content.innerHTML += '<div class="row"><p class="answer"> Ditt svar: ' + escapeHTML(answer) + '</p><i class="material-icons icon correct">check_circle</i></div>';
    }
    else   //Om ett korrekt svar har skickats med är användarens svar fel, placera ut text mm...                                     
    {
        content.innerHTML += '<div class="row"><p class="answer"> Ditt svar: ' + escapeHTML(answer) + '</p><i class="material-icons icon wrong">error</i></div>';

        content.innerHTML += '<p class="answer"> Korrekt svar: ' + escapeHTML(correct_answer) + '</p>';
    }

    popup.style.display = "flex";
}

/*
*   Denna funktion tar inargumentet och returnerar det med escape-tecken
*   för HTML-taggar
*/
function escapeHTML(str)
{
    var pre = document.createElement('pre');    //Skapa ett nytt HTML-element
    var text = document.createTextNode(str);    //Skapa en text-nod med inargumentet i
    pre.appendChild(text);                      //Lägg till text-noden till HTML-elementet

    /*
    *   När text-noden lades till till HTML-elementet skapades nödvändiga escape-tecken,
    *   hämta värdet från HTML-elementet och returnera detta
    */
    return pre.innerHTML;
}




