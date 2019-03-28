document.addEventListener("DOMContentLoaded", initialize, false);    //Körs när hemsidan öppnas

var bar = document.getElementById("progress-bar");

function initialize()
{
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            bar.max = this.responseText;
        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=get+nr+of+questions", false);
    xmlhttp.send();

    setQuestionsLeft();
    loadQuestion();
    loadAnswers();   
}

function setQuestionsLeft()
{
    var xmlhttp = new XMLHttpRequest();

    var questionsLeft = document.getElementById("questions-left");

    
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            questionsLeft.innerHTML = this.responseText + " frågor kvar";

        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=get+questions+left", false);
    xmlhttp.send();
}

function loadQuestion()
{
    var xmlhttp = new XMLHttpRequest();
    
    
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            document.getElementById("question-text").innerHTML = this.responseText;
        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=load+question", false);
    xmlhttp.send();
}

function loadAnswers()
{
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            document.getElementById("alternatives").innerHTML = this.responseText;
        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=load+answers", false);
    xmlhttp.send();
}

function printError(obj)
{
    alert('Error: ' + obj.status);
}

function nextQuestion()
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "requires/quizhandler.php?request=next+question", false);
    xmlhttp.send();
}

function gotoNext()
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            bar.value++;

            if(this.responseText) 
            {
                setQuestionsLeft();

                setTimeout(function()
                {
                    window.location.href = "result";
                }, 1000);
            }
            else
            {

                nextQuestion();
                loadQuestion();
                loadAnswers();
                setQuestionsLeft();

            }
        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=is+last+question", false);
    xmlhttp.send();
}

function disableButtons()
{
    var buttons = document.getElementsByClassName("alternative");
    
    for(let e of buttons)   e.disabled = true;
}

function addAnswer(text, is_correct)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "requires/quizhandler.php?request=add+answer&text=" + text + "&is_correct=" + is_correct, false);
    xmlhttp.send();
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
