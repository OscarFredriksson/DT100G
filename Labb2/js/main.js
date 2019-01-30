"use strict";   //Kör i strikt läge. Ger t.ex error om variabler som inte är deklarerade används

var baseURL = "http://api.arbetsformedlingen.se/af/v0";

//Körs när hemsidan öppnas
document.addEventListener("DOMContentLoaded", loadFront(), false); 
document.getElementById("logo").addEventListener('click', loadFront, false);

function loadFront()
{
    var lanlista = document.getElementById("mainnavlist");
    lanlista.innerHTML = "";

    document.getElementById("info").innerHTML = "";

    var xmlhttp = new XMLHttpRequest();

    // Read all LÄN and dynamically create list from AF
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) 
        {
           if (xmlhttp.status == 200) 
           {
                document.getElementById("searchlan").innerHTML = "";
                var jsonData = JSON.parse(xmlhttp.responseText);
                for(var i = 0; i < jsonData.soklista.sokdata.length; i++)
                {
                    lanlista.innerHTML += "<li id='" + jsonData.soklista.sokdata[i].id + "'>" + jsonData.soklista.sokdata[i].namn + " (" + jsonData.soklista.sokdata[i].antal_ledigajobb + ")</li>";    
                    document.getElementById("searchlan").innerHTML += "<option value='" + jsonData.soklista.sokdata[i].id + "'>" + jsonData.soklista.sokdata[i].namn + "</option>";      
                }
           }
           else if (xmlhttp.status == 400)  alert('There was an error 400');
           else                             alert('something else other than 200 was returned');
           
        }
    };

    xmlhttp.open("GET", baseURL + "/platsannonser/soklista/lan", true);
    xmlhttp.send();
};


//Körs när ett av länen i listan klickas
document.getElementById('mainnavlist').addEventListener("click", function(e)
{    
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) 
        {
           if (xmlhttp.status == 200) 
           {
                var jsonData = JSON.parse(xmlhttp.responseText);
                
                //Hantera hämtad data
                for(var i = 0; i < jsonData.matchningslista.matchningdata.length; i++)
                {
                    var element = document.getElementById("info");

                    //Data:
                    element.innerHTML += "<h3>" + jsonData.matchningslista.matchningdata[i].annonsrubrik + "</h3>";
                    element.innerHTML += "<h4>" + jsonData.matchningslista.matchningdata[i].yrkesbenamning + "</h4>";
                    element.innerHTML += "<h4>" + "Anställningstyp: " +  "??????????" + "</h4>";
                    element.innerHTML += "<h4>" + "Antal platser: " + jsonData.matchningslista.matchningdata[i].antalplatser + "</h4>";
                    element.innerHTML += "<h4>" + "Publicersingsdatum: " + jsonData.matchningslista.matchningdata[i].publiceraddatum + "</h4>";
                    element.innerHTML += "<h4>" + "Sista ansökningsdag: " + "??????????" + "</h4>";
                    
                    //Knapp:
                    element.innerHTML += "<form action='" + jsonData.matchningslista.matchningdata[i].annonsurl + "'><button type='searchbutton' class='btn'> Läs Mer </button></form>";
                    
                    element.innerHTML += "<hr>";    //Divider line
                }
           }
           else if (xmlhttp.status == 400)  alert('There was an error 400');
           else                             alert('something else other than 200 was returned');
           
        }
    };

    var request = baseURL + "/platsannonser/matchning?lanid=" + e.target.id;
    xmlhttp.open("GET", request, true);
    xmlhttp.send();

});
