function playButtonClicked(obj)
{
    window.location.href = "play?id=" + obj.id;
}

function deleteQuiz(id)
{
    if(confirm("Vill du verkligen ta bort quizzet?"))   alert("funkar inte än :(");
}
