"use strict";   //Kör i strikt läge. Ger t.ex error om variabler som inte är deklarerade används

var baseURL = "http://api.arbetsformedlingen.se/af/v0";

//Körs när hemsidan öppnas
document.addEventListener("DOMContentLoaded", loadFront, false); 
document.getElementById("logo").addEventListener('click', loadFront, false);

function loadFront()
{
    var lanlista = document.getElementById("mainnavlist");
    lanlista.innerHTML = "";

    var lanDropDown = document.getElementById("searchlan");
    lanDropDown.innerHTML = "";

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

                jsonData.soklista.sokdata.forEach(function(data)
                {
                    lanlista.innerHTML += "<li id='" + data.id + "'>" + data.namn + " (" + data.antal_ledigajobb + ")</li>";    
                    lanDropDown.innerHTML += "<option value='" + data.id + "'>" + data.namn + "</option>";      
                });
           }
           else if (xmlhttp.status == 400)  alert('There was an error 400');
           else                             alert('something else other than 200 was returned');
           
        }
    };

    xmlhttp.open("GET", baseURL + "/platsannonser/soklista/lan", true);
    xmlhttp.send();
};

function loadData(data)
{
    var element = document.getElementById("info");
                    
    //Data:
    element.innerHTML += "<h3>" + data.annonsrubrik + "</h3>";
    element.innerHTML += "<h4>" + data.yrkesbenamning + "</h4>";
    element.innerHTML += "<h4>" + "Anställningstyp: " +  data.anstallningstyp + "</h4>";
    element.innerHTML += "<h4>" + "Antal platser: " + data.antalplatser + "</h4>";
    element.innerHTML += "<h4>" + "Publicersingsdatum: " + data.publiceraddatum + "</h4>";
    element.innerHTML += "<h4>" + "Sista ansökningsdag: " + data.sista_ansokningsdag + "</h4>";
    
    //Knapp:
    element.innerHTML += "<form action='" + data.annonsurl + "'><button type='searchbutton' class='btn'> Läs Mer </button></form>";
    
    element.innerHTML += "<hr>";    //Divider line
}

function loadRegionContent(regionID)
{
    document.getElementById("info").innerHTML = "";

    var rows = document.getElementById("numrows").value;
    var onlyIT = document.getElementById("onlyit").checked;

    //Bygg ihop request-strängen:
    var request = baseURL + "/platsannonser/matchning?lanid=" + regionID + "&antalrader=" + rows;
    
    if(onlyIT) request += "&yrkesomradeid=3";    //Om onlyIT är ibockad, lägg till specificering av yrkesområde

    

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) 
        {
           if (xmlhttp.status == 200) 
           {
                var jsonData = JSON.parse(xmlhttp.responseText);
                
                jsonData.matchningslista.matchningdata.forEach(loadData);   //Ladda in data              
           }
           else if (xmlhttp.status == 400)  alert('There was an error 400');
           else                             alert('something else other than 200 was returned');
           
        }
    };

    xmlhttp.open("GET", request, true);
    xmlhttp.send();

}

//Körs när ett av länen i listan klickas
document.getElementById('mainnavlist').addEventListener("click", function(e)
{    
    loadRegionContent(e.target.id);
    document.getElementById("searchlan").value = e.target.id;
});

document.getElementById("searchbutton").addEventListener("click", function()
{
    var searchText = document.getElementById("searchText").value;     

    if(!searchText) return;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) 
        {
           if (xmlhttp.status == 200) 
           {
                var jsonData = JSON.parse(xmlhttp.responseText);
                
                var element = document.getElementById("info");
                element.innerHTML = "";
                
                jsonData.soklista.sokdata.forEach(function(data)
                {
                    element.innerHTML += "<h3>" + data.namn + "</h3>";
                    element.innerHTML += "<h4>" + "Antal platsannonser: " + data.antal_platsannonser + "</h4>";
                    element.innerHTML += "<h4>" + "Antal lediga jobb:" + data.antal_ledigajobb + "</h4>";
                    element.innerHTML += "<h4>" + "ID: " + data.id + "</h4>";
                    element.innerHTML += "<h4>" + "Namn: " + data.namn + "</h4>";
                    
                    element.innerHTML += "<hr>";    //Divider line
                });                
           }
           else if (xmlhttp.status == 400)  alert('There was an error 400');
           else                             alert('something else other than 200 was returned');
           
        }
    };

    var request = baseURL + "/platsannonser/soklista/yrken/" + searchText;
    xmlhttp.open("GET", request, true);
    xmlhttp.send();
});
