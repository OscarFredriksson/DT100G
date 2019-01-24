
document.getElementById("result_page").style.display = 'none';

//När "nollställ" knappen trycks
document.getElementById("reset").addEventListener("click", function()
{
    //Spara alla fält
    var inputTextFields = [
                            document.getElementById("input-company"),
                            document.getElementById("input-lastname"),
                            document.getElementById("input-firstname"),
                            document.getElementById("input-title"),
                            document.getElementById("input-phone"),
                            document.getElementById("input-email")
                        ];

    inputTextFields.forEach(function(obj)   //Loopa igenom alla text-objekt och rensa fältet
    {
        obj.value = "";
    });

    document.getElementById("input-backgroundcolor").selectedIndex = 0;
    document.getElementById("input-textcolor").selectedIndex = 0;
    document.getElementById("input-font").selectedIndex = 0;

});

//När "skriv ut" knappen trycks
document.getElementById("submit").addEventListener("click", function(){

    document.getElementById("order_page").style.display = 'none';
    document.getElementById("result_page").style.display = 'block';

    //Spara alla textobjekt för att kunna iterera igenom dessa senare
    var cardTextObjects = [
                        document.getElementById("card-company"),
                        document.getElementById("card-name"),
                        document.getElementById("card-title"),
                        document.getElementById("card-phone"),
                        document.getElementById("card-email")
                    ];

    //Sätter text-fält:
    cardTextObjects[0].innerHTML = document.getElementById("input-company").value;
    cardTextObjects[1].innerHTML = document.getElementById("input-firstname").value + " " + document.getElementById("input-lastname").value;
    cardTextObjects[2].innerHTML = document.getElementById("input-title").value;
    cardTextObjects[3].innerHTML = document.getElementById("input-phone").value;
    cardTextObjects[4].innerHTML = document.getElementById("input-email").value;

    //Sätter bakgrundsfärg:
    var backgroundColor = document.getElementById("input-backgroundcolor").value;
    document.getElementById("result_page").style.backgroundColor = backgroundColor;

    
    //Sätter textfärg:
    var textColor = document.getElementById("input-textcolor").value;

    cardTextObjects.forEach(function(obj)   //Loopar igenom alla text-objekt och sätt text-färg
    {
        obj.style.color = textColor;
    });


    //Sätter font:
    var choosenFont = document.getElementById("input-font").value;

    cardTextObjects.forEach(function(obj)   //Loopar igenom alla text-objekt och sätt font
    {
        obj.style.fontFamily = choosenFont;
    });

});
