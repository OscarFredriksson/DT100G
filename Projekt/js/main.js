function playButtonClicked(obj)
{
    window.location.href="quizpage?id=" + obj.id;
}

function checkAnswer(obj)
{
    if(obj.id == "correct") alert("Rätt svar! :D");
    else                    alert("Fel svar :(");
}
