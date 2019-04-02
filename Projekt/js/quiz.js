/*
*   På många ställen i denna kod används callback funktioner, detta används där
*   ordningen av vissa förfrågningar spelar roll, t.ex om en viss ajax förfrågan 
*   måste ske före en annan för att koden ska fungera korrekt.
*/



document.addEventListener("DOMContentLoaded", initialize, false);    //Körs när hemsidan öppnas

window.onbeforeunload = function()  //Visa varningsruta om användaren håller på att lämna sidan
{
    return true;
}

var progressBar = document.getElementById("progress-bar");  //Spara elementet för progress-baren så den kan uppdateras enkelt

function initialize()   //Starta quizzet och sätt ut startvärden
{
    initializeProgressBar();
    setQuestionsLeft();
    placeQuestion();
    placeAlternatives();   
}

/*
*   Skicka  en ajaxförfrågning till den givna url-en.
*   När ett svar fås skickas detta till callback funktionen
*/
function sendAjax(url, callback)    
{
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            if(callback)    callback(this.responseText);
        }
        else
        {
            alert('Error: ' + this.status);
        }
    };
    
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function initializeProgressBar()
{
    sendAjax("requires/quizhandler.php?request=get+nr+of+questions", function(response)
    {
        progressBar.max = response; //sätt maxvärde för progressbaren
    });
}

function setQuestionsLeft()
{
    sendAjax("requires/quizhandler.php?request=get+questions+left", function(response)
    {
        var questionsLeft = document.getElementById("questions-left");

        if(response == 1)   questionsLeft.innerHTML = response + " fråga kvar";
        else                questionsLeft.innerHTML = response + " frågor kvar";
    });
}

function placeQuestion()
{
    sendAjax("requires/quizhandler.php?request=load+question", function(response)
    {
        document.getElementById("question-text").innerHTML = response;
    });
}

function placeAlternatives(callback)
{
    sendAjax("requires/quizhandler.php?request=load+answers", function(response)
    {
        document.getElementById("alternatives").innerHTML = response;
        
        if(callback)    callback();
    });
}

function nextQuestion(callback)
{
    sendAjax("requires/quizhandler.php?request=next+question", function()
    {
        if(callback)    callback();
    });
}

function gotoNext(callback)
{
    /*
    *   Resterande kod behöver vänta på att "next question" förfrågningen blir färdig för att
    *   det inte ska bli synkroniseringsfel, använd därför callback-funktionen för denna.
    */

    nextQuestion(function()
    {
        progressBar.value++;
        
        setQuestionsLeft();

        sendAjax("requires/quizhandler.php?request=is+finished", function(response)
        {
            if(response) 
            {
                setTimeout(function()
                {
                    window.onbeforeunload = null;
                    window.location.href = "result";
                }, 1000);
            }
            else
            {
                placeQuestion();
                placeAlternatives();
            }

            if(callback)    callback();
        });
    });
}

function disableButtons()
{
    var buttons = document.getElementsByClassName("alternative");
    
    for(let e of buttons)   e.disabled = true;
}

function addUserAnswer(text, is_correct, callback)
{
    sendAjax("requires/quizhandler.php?request=add+answer&text=" + text + "&is_correct=" + is_correct, function()
    {
        if(callback)    callback();
    });
}

function checkAnswer(text, is_correct, obj)
{
    disableButtons();

    var color;
    if(is_correct == 1) color = getComputedStyle(document.documentElement).getPropertyValue('--correct-color');
    else                color = getComputedStyle(document.documentElement).getPropertyValue('--wrong-color');

    document.documentElement.style.setProperty('--clicked-answer-color', color);

    obj.style.backgroundPosition = "left bottom";


    setTimeout(function()
    {
        addUserAnswer(text, is_correct, function()
        {
            gotoNext();
        });
        
    }, 1000);
}
