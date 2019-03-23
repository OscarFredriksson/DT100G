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

function checkAnswer(obj)
{
    nextQuestion(); //Låt nästa fråga börja laddas...

    obj.style.backgroundPosition = "left bottom";

    setTimeout(loadQuiz, 1000);
}
