var popup = document.getElementById('popup');
var closeBtn = document.getElementById('close');

closeBtn.onclick = function()
{
    popup.style.display = "none";
}

function showAnswer(question, answer, correct_answer)
{    
    var content = document.getElementById('popup-content');

    content.innerHTML = '<h2 class="question">Fråga: ' + question + '</h2>';

    if(typeof correct_answer === 'undefined')
    {
        content.innerHTML += '<div class="row"><p class="answer"> Ditt svar: ' + answer + '</p><i class="material-icons icon correct">check_circle</i></div>';
    }
    else                                        
    {
        content.innerHTML += '<div class="row"><p class="answer"> Ditt svar: ' + answer + '</p><i class="material-icons icon wrong">error</i></div>';

        content.innerHTML += '<p class="answer"> Korrekt svar: ' + correct_answer + '</p>';
    }

    popup.style.display = "flex";
}




