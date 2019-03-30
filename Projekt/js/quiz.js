document.addEventListener("DOMContentLoaded", initialize, false);    //Körs när hemsidan öppnas

var progressBar = document.getElementById("progress-bar");

function initialize()
{
    initializeProgressBar();
    setQuestionsLeft();
    loadQuestion();
    loadAnswers();   
}

function initializeProgressBar()
{
    sendAjax("requires/quizhandler.php?request=get+nr+of+questions", function(response)
    {
        progressBar.max = response;
    });
}

function sendAjax(url, callback)
{
    // compatible with IE7+, Firefox, Chrome, Opera, Safari
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            callback(this.responseText);
        }
        else
        {
            alert('Error: ' + obj.status);
        }
    };
    
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
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

function loadQuestion()
{
    sendAjax("requires/quizhandler.php?request=load+question", function(response)
    {
        document.getElementById("question-text").innerHTML = response;
    });
}

function loadAnswers()
{
    sendAjax("requires/quizhandler.php?request=load+answers", function(response)
    {
        document.getElementById("alternatives").innerHTML = response;
    });
}

function nextQuestion()
{
    sendAjax("requires/quizhandler.php?request=next+question");
}

function gotoNext()
{
    sendAjax("requires/quizhandler.php?request=is+finished", function(response)
    {
        progressBar.value++;
        nextQuestion();
        setQuestionsLeft();

        if(response) 
        {
            setTimeout(function()
            {
                window.location.href = "result";
            }, 1000);
        }
        else
        {
            loadQuestion();
            loadAnswers();
        }
    });
}

function disableButtons()
{
    var buttons = document.getElementsByClassName("alternative");
    
    for(let e of buttons)   e.disabled = true;
}

function addAnswer(text, is_correct)
{
    sendAjax("requires/quizhandler.php?request=add+answer&text=" + text + "&is_correct=" + is_correct);
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
        addAnswer(text, is_correct);
        gotoNext();
    }, 1000);
}
