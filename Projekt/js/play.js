/*
*   Denna fil innehåller javascript-koden för play.php sidan. 
*
*   Huvudsyftet för koden i denna fil är att hämta och fylla hemsidan med frågor och alternativ
*   för quizzet. Detta sker dynamiskt med hjälp av ajax.
*
*   På många ställen i denna kod används callback funktioner, detta används där
*   ordningen av vissa förfrågningar spelar roll, t.ex om en viss ajax förfrågan 
*   måste ske före en annan för att koden ska fungera korrekt.
*
*   All kod är skriven av Oscar Fredriksson   
*/

document.addEventListener("DOMContentLoaded", initialize, false);    //När hemsidan laddas, kör initialize funktionen

window.onbeforeunload = function()  //Visa varningsruta om användaren håller på att lämna sidan
{
    return true;
}

var progressBar = document.getElementById("progress-bar");  //Spara elementet för progress-baren så den kan uppdateras enkelt

function initialize()   //Starta quizzet och sätt ut startvärden
{
    placeQuestion();            //Placera ut frågetexten
    placeAlternatives();        //Placera ut alternativen
    setQuestionsLeft();         //Sätt ut texten för hur många frågor det är kvar 
    initializeProgressBar();    //Sätt startvärde för progress-baren
}

/*
*   Skicka  en ajaxförfrågning till den givna url-en.
*   När ett svar fås skickas detta till callback funktionen
*/
function sendAjax(url, callback)    
{
    var xmlhttp = new XMLHttpRequest(); //Skapa ett nytt request-objekt
    
    xmlhttp.onreadystatechange = function() //Körs när requesten får tillbaka data
    {
        if (this.readyState != XMLHttpRequest.DONE) return; //Om requesten inte fått tillbaka all data än, avvakta
        
        if(this.status == 200)  //Om allt gick bra, hantera datat:
        {
            if(callback)    callback(this.responseText);    //Skicka datat till callback funktionen
        }
        else    //Om det inte gick bra
        {
            alert('Error: ' + this.status); //Skriv ut felmeddelandet
        }
    };
    
    //Skicka requesten:
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function initializeProgressBar()    //Sätt startvärde för progress-baren
{
    //Skicka en ajax förfrågan till servern för att be om antalet frågor för quizzet
    sendAjax("requires/quizhandler.php?request=get+nr+of+questions", function(response) //funktionen körs när förfrågan får svar från servern
    {
        progressBar.max = response; //sätt maxvärdet för progress-baren till antalet frågor
    });
}

function setQuestionsLeft() //Sätt ut texten för hur många frågor det är kvar
{   
    //Skicka en ajax förfrågan till servern för hur många frågor det är kvar
    sendAjax("requires/quizhandler.php?request=get+questions+left", function(response) //funktionen körs när förfrågan får svar från servern
    {
        var questionsLeft = document.getElementById("questions-left");  //Spara objektet  

        //Sätt värdet för hur många frågor det är kvar
        if(response == 1)   questionsLeft.innerHTML = response + " fråga kvar"; 
        else                questionsLeft.innerHTML = response + " frågor kvar";
    });
}

function placeQuestion()    //Placera ut texten för frågan
{
    //Skicka en ajax förfrågan till servern för att få frågetexten
    sendAjax("requires/quizhandler.php?request=get+question", function(response)    //Funktionen körs när förfrågan får svar från servern
    {
        document.getElementById("question-text").innerHTML = response;  //Sätt HTML-elementets värde till svaret
    });
}

function placeAlternatives()    //Placera ut knapparna för alternativen
{
    //Skicka en ajax förfrågan till servern för att få HTML-koden för alla alternativ
    sendAjax("requires/quizhandler.php?request=get+alternatives", function(response)
    {
        //Fyll alternativ-sektionen med svaret
        document.getElementById("alternatives").innerHTML = response;   
    });
}

/*
*   Säg åt servern att gå till nästa fråga. 
*   Eftersom det är viktigt att denna förfrågan görs färdigt innan t.ex frågetexten
*   laddas används en callback funktion som körs när förfrågan är klar.
*/
function requestNextQuestion(callback) 
{
    //Skicka en ajax förfrågan till servern att gå till nästa fråga
    sendAjax("requires/quizhandler.php?request=next+question", function()   //Funktionen körs när servern är klar med förfrågan
    {
        if(callback)    callback(); //När förfrågan är färdig, kör callback funktionen
    });
}

function gotoNextQuestion() //Gå till nästa fråga
{
    /*
    *   Resterande kod behöver vänta på att "next question" förfrågningen blir färdig för att
    *   det inte ska bli synkroniseringsfel, använd därför callback-funktionen för denna.
    */
    requestNextQuestion(function() //När förfrågan är färdig körs funktionen
    {
        //Dessa körs ovan för de ska köras oavsett om quizzet är färdigt eller inte
        progressBar.value++;    //Öka värdet för progressbaren (och flytta därmed fram den ett steg)
        setQuestionsLeft(); //Sätt texten för hur många frågor det är kvar

        //Skicka en förfrågan för att se om quizzet är färdigspelat (alltså att föregående fråga var den sista)
        sendAjax("requires/quizhandler.php?request=is+finished", function(response)
        {
            if(response)    //Om förfrågan får "1" som svar är quizzet färdigspelat 
            {
                setTimeout(function()   //Vänta 1 sekund för att progress-baren ska få animera färdigt
                {
                    window.onbeforeunload = null;       //Avvaktivera varningsruta för att lämna sidan
                    window.location.href = "result";    //Gå till resultatsidan
                }, 1000);
            }
            else    //Annars är quizzet inte färdigspelat
            {       
                placeQuestion();        //Placera ut text för den nya frågan
                placeAlternatives();    //Placera ut de nya alternativen
            }
        });
    });
}

function disableButtons()   //Avaktivera alla alternativknappar så användaren inte kan trycka på dem
{
    var buttons = document.getElementsByClassName("alternative");   //Hämta alla alternativknappar
    
    for(let e of buttons)   e.disabled = true;  //Gå igenom allihop och avaktivera dem
}


/*
*   Lägg till vilket alternativ användaren klickade på till servern.
*   Denna behöver bli färdig innan nästa fråga kan laddas, så använd en callback-funktion
*/
function addUserAnswer(text, is_correct, callback)  //Plocka in argument för alternativets text samt om det är korrekt eller inte
{
    //Skicka en ajax förfrågan med värdena så de kan läggas till på servern
    sendAjax("requires/quizhandler.php?request=add+answer&text=" + text + "&is_correct=" + is_correct, function()
    {
        if(callback)    callback(); //När förfrågan är färdig, kör callback funktionen
    });
}

/*
*   Denna funktion körs när ett av alternativknapparna klickas, 
*   då skickas in om alternativet är korrekt samt HTML-elementet, så 
*   en animation kan appliceras till denna samt att dess värde kan hämtas. 
*/
function checkAnswer(is_correct, obj) 
{
    disableButtons();   //Avaktivera alla alternativknappar så användaren inte kan klicka på nått mer alternativ

    //Hämta en färg från :root i CSS-filen beroende på om svaret var rätt eller inte
    var color;  
    if(is_correct == 1) color = getComputedStyle(document.documentElement).getPropertyValue('--correct-color');
    else                color = getComputedStyle(document.documentElement).getPropertyValue('--wrong-color');

    //Sätt knappens bakgrundsfärg till det hämtade värdet
    document.documentElement.style.setProperty('--clicked-answer-color', color);    

    obj.style.backgroundPosition = "left bottom";   //Animera in den nya färgen

    //Vänta 1 sekund för att låta knappen animeras, lägg sedan till användarens svar och gå vidare
    setTimeout(function()
    {
        //Lägg till användarens svar, när detta är klart gå till nsäta fråga
        addUserAnswer(obj.value, is_correct, function() 
        {
            gotoNextQuestion();
        });
        
    }, 1000);
}
