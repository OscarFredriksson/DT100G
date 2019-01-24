

document.getElementById("result_page").style.display = 'none';

document.getElementById("submit").addEventListener("click", function(){

    document.getElementById("order_page").style.display = 'none';
    document.getElementById("result_page").style.display = 'block';

    
    //Spara alla textobjekt för att kunna iterera igenom dessa senare
    var textObjects = [
                        document.getElementById("card-company"),
                        document.getElementById("card-name"),
                        document.getElementById("card-title"),
                        document.getElementById("card-phone"),
                        document.getElementById("card-email")
                    ];

    //Sätter text:
    textObjects[0].innerHTML = document.getElementById("input-company").value;
    textObjects[1].innerHTML = document.getElementById("input-firstname").value + " " + document.getElementById("input-lastname").value;
    textObjects[2].innerHTML = document.getElementById("input-title").value;
    textObjects[3].innerHTML = document.getElementById("input-phone").value;
    textObjects[4].innerHTML = document.getElementById("input-email").value;

    //Sätter bakgrundsfärg:
    var backgroundColor = document.getElementById("input-backgroundcolor").value;
    document.getElementById("result_page").style.backgroundColor = backgroundColor;

    
    //Sätter textfärg:
    var textColor = document.getElementById("input-textcolor").value;

    textObjects.forEach(function(obj)
    {
        obj.style.color = textColor;
    });


    //Sätter font:
    var choosenFont = document.getElementById("input-font").value;

    textObjects.forEach(function(obj)
    {
        obj.style.fontFamily = choosenFont;
    });

});
