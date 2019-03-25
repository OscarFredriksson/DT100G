document.addEventListener("DOMContentLoaded", loadQuiz, false);    //Körs när hemsidan öppnas

function loadQuiz()
{
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            document.getElementById("content").innerHTML = this.responseText;
        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=load+question", true);
    xmlhttp.send();
}

function printError(obj)
{
    alert('Error: ' + obj.status);
}

function nextQuestion()
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "requires/quizhandler.php?request=next+question", true);
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
            if(this.responseText) window.location.href = "result";
            else
            {
                nextQuestion();
                loadQuiz();
            }
        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=is+last+question", true);
    xmlhttp.send();
}

function checkAnswer(obj)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState != XMLHttpRequest.DONE) return;
        
        if(this.status == 200) 
        {
            var color;
            if(this.responseText == 1)  color = getComputedStyle(document.documentElement).getPropertyValue('--correct-color');
            else                        color = getComputedStyle(document.documentElement).getPropertyValue('--wrong-color');

            document.documentElement.style.setProperty('--clicked-answer-color', color);

            obj.style.backgroundPosition = "left bottom";

        }
        else printError(xmlhttp);

    };

    xmlhttp.open("GET", "requires/quizhandler.php?request=check+answer&answer_id=" + obj.id, true);
    xmlhttp.send();

    setTimeout(gotoNext, 1000);
}
