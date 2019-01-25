"use strict";   //Kör i strikt läge. Ger t.ex error om variabler som inte är deklarerade används

var baseURL = "http://api.arbetsformedlingen.se/af/v0";


//Körs när hemsidan öppnas??
document.addEventListener("DOMContentLoaded", function()
{ 
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
                   document.getElementById("mainnavlist").innerHTML += "<li id='" + jsonData.soklista.sokdata[i].id + "'>" + jsonData.soklista.sokdata[i].namn + " (" + jsonData.soklista.sokdata[i].antal_ledigajobb + ")</li>";    
                   document.getElementById("searchlan").innerHTML += "<option value='" + jsonData.soklista.sokdata[i].id + "'>" + jsonData.soklista.sokdata[i].namn + "</option>";      
                }
           }
           else if (xmlhttp.status == 400)  alert('There was an error 400');
           else                             alert('something else other than 200 was returned');
           
        }
    };

    xmlhttp.open("GET", baseURL + "/platsannonser/soklista/lan", true);
    xmlhttp.send();
}); 


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
                //alert(xmlhttp.responseText);

                var jsonData = JSON.parse(xmlhttp.responseText);
                
                //Hantera hämtad data
                
           }
           else if (xmlhttp.status == 400)  alert('There was an error 400');
           else                             alert('something else other than 200 was returned');
           
        }
    };

    var request = baseURL + "/platsannonser/matchning?lanid=" + e.target.id;
    xmlhttp.open("GET", request, true);
    xmlhttp.send();

});