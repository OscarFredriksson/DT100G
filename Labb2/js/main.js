"use strict";   //Kör i strikt läge. Ger t.ex error om variabler som inte är deklarerade används

const baseURL = "http://api.arbetsformedlingen.se/af/v0";

//Spara alla ID'n för olika html-element
const regionList_ID = "mainnavlist";
const regionDropDown_ID = "searchlan";
const content_ID = "info";
const logo_ID = "logo";
const numRows_ID = "numrows";
const onlyIT_ID = "onlyit";
const searchButton_ID = "searchbutton";
const searchBox_ID = "searchText"

const numRows_default = 20; //Default-värdet för antal rader 

document.addEventListener("DOMContentLoaded", loadFront, false);    //Körs när hemsidan öppnas

document.getElementById(logo_ID).addEventListener("click", loadFront, false);

function loadFront()    //Laddar framsidan, läser in alla län till listan och dropdown-boxen
{
    document.getElementById(regionList_ID).innerHTML = "";    //Töm länlistan
    document.getElementById(regionDropDown_ID).innerHTML = ""; //Töm län-dropdownboxen
    document.getElementById(content_ID).innerHTML = ""; //Töm infofönstret 

    var request = baseURL + "/platsannonser/soklista/lan";  //Request-kommandot som ska skickas till API'n

    var xmlhttp = new XMLHttpRequest(); //skapa ett nytt request-objekt

    xmlhttp.onreadystatechange = function() //Körs när requesten får tillbaka data från API'n 
    {
        if(xmlhttp.readyState != XMLHttpRequest.DONE)  return;  //Om requesten inte fått tillbaka all data än, avvakta

        if(xmlhttp.status == 200)   //Om allt gick bra, hantera data:
        {
            var jsonData = JSON.parse(xmlhttp.responseText);    //Datan kommer som en sträng, använd json för att skapa ett objekt som håller datan istället

            jsonData.soklista.sokdata.forEach(function(data)    //Går igenom alla data
            {
                //Lägg till varje län till både listan och dropdown-boxen
                document.getElementById(regionList_ID).innerHTML += "<li id='" + data.id + "'>" + data.namn + " (" + data.antal_ledigajobb + ")</li>";    
                document.getElementById(regionDropDown_ID).innerHTML += "<option value='" + data.id + "'>" + data.namn + "</option>";      
            });

            resetSelections();  //Återställ valt län, antal rader och endast data/it till deras defaultvärden
        }
        else printReturnInfo(xmlhttp);      

    };

    //Skicka requesten:
    xmlhttp.open("GET", request, true);
    xmlhttp.send();
};

function resetSelections()  //Återställer valt län, hur många rader som ska visas och "endast Data/IT"-boxen
{
    document.getElementById(numRows_ID).value = numRows_default; //Sätt valt antal rader till 20
    
    document.getElementById(onlyIT_ID).checked = false; //Avbocka "endast Data/IT"
    
    document.getElementById(regionDropDown_ID).selectedIndex = 21;  //Sätt valt län till ospecificerad
}

function printReturnInfo(obj)   //Skriver ut info om returvärde från en XMLHttpRequest
{
    if (obj.status == 400)  alert('There was an error 400');
    else                    alert('something else other than 200 was returned');
}

document.getElementById(regionDropDown_ID).addEventListener("change", function()  //Körs när det byts län i dropdown-boxen
{
    var regionID = document.getElementById(regionDropDown_ID).value;  //ID't för det valda länet

    loadRegionSpecifiedContent(regionID); //Ladda in data för det valda länet
});

//Körs när ett av länen i listan klickas
document.getElementById(regionList_ID).addEventListener("click", function(e)
{
    document.getElementById(regionDropDown_ID).value = e.target.id;   //Sätt län-dropdownboxens värde till det som precis klickades 
    
    loadRegionSpecifiedContent(e.target.id);    //Ladda in data för det valda länet
});

document.getElementById(numRows_ID).addEventListener("change", function()
{
    var element = document.getElementById(numRows_ID);

    if(element.value == 0)  element.value = numRows_default;   //Om boxen är tom, återställ till default

    var regionID = document.getElementById(regionDropDown_ID).value;  //IDt för det valda länet

    loadRegionSpecifiedContent(regionID); //Ladda in data för det valda länet
});

document.getElementById(onlyIT_ID).addEventListener("change", function()
{
    var regionID = document.getElementById(regionDropDown_ID).value;  //IDt för det valda länet

    loadRegionSpecifiedContent(regionID); //Ladda in data för det valda länet
});

function loadRegionSpecifiedContent(regionID)
{
    var rows = document.getElementById(numRows_ID).value;       //Spara valt antal rader att visa
    var onlyIT = document.getElementById(onlyIT_ID).checked;    //Spara om "endast Data/IT" är ibockat eller inte

    var request = baseURL + "/platsannonser/matchning?lanid=" + regionID + "&antalrader=" + rows;   //Bygg ihop request-kommandot
    
    if(onlyIT) request += "&yrkesomradeid=3";    //Om "endast Data/IT" är ibockad, lägg till specificering av yrkesområde


    var xmlhttp = new XMLHttpRequest(); //Skapa ett nytt request-objekt

    xmlhttp.onreadystatechange = function() //Körs när requesten får tillbaka data från APIn 
    {
        if(xmlhttp.readyState != XMLHttpRequest.DONE)  return; //Om requesten inte har fått all data än, avvakta
        
        if(xmlhttp.status == 200)  //Om allt gick bra, hantera datan:
        {
            var jsonData = JSON.parse(xmlhttp.responseText);    //Datan kommer som en sträng, använd json för att skapa ett objekt som håller datan istället
            
            document.getElementById(content_ID).innerHTML = ""; //Töm utifall det finns nått innehåll

            jsonData.matchningslista.matchningdata.forEach(placeData);   //Placera data på sidan            
        }
        else printReturnInfo(xmlhttp);  //Annars skriv ut felmeddelande   
    };

    //Skicka requesten:
    xmlhttp.open("GET", request, true);
    xmlhttp.send();
}

function placeData(data)    //Placerar data på sidan
{
    var element = document.getElementById(content_ID);
                    
    //Placerar data:
    element.innerHTML += "<h3>" + data.annonsrubrik + "</h3>";
    element.innerHTML += "<h4>" + data.yrkesbenamning + "</h4>";
    element.innerHTML += "<h4>" + "Anställningstyp: " +  data.anstallningstyp + "</h4>";
    element.innerHTML += "<h4>" + "Antal platser: " + data.antalplatser + "</h4>";
    element.innerHTML += "<h4>" + "Publicersingsdatum: " + data.publiceraddatum + "</h4>";
    element.innerHTML += "<h4>" + "Sista ansökningsdag: " + data.sista_ansokningsdag + "</h4>";
    
    //Lägger dit "Läs Mer" knappen:
    element.innerHTML += "<form action='" + data.annonsurl + "'><button type='searchbutton' class='btn'> Läs Mer </button></form>";
    
    element.innerHTML += "<hr>";    //Skriv en indelningslinje
}

document.getElementById(searchButton_ID).addEventListener("click", function()
{
    resetSelections();  //Återställ alla val (län, antal rader, endast data/IT)

    var searchText = document.getElementById(searchBox_ID).value;     //Hämtar den sträng som ska sökas efter

    if(!searchText) return; //Om den är tom, gör ingenting

    var request = baseURL + "/platsannonser/soklista/yrken/" + searchText;  //Bygg ihop request-kommandot

    var xmlhttp = new XMLHttpRequest(); //Skapa ett nytt request-objekt

    xmlhttp.onreadystatechange = function() //Körs när requesten får tillbaka data från APIn
    {
        if(xmlhttp.readyState != XMLHttpRequest.DONE)  return; //Om requesten inte har fått all data än, avvakta
        
        if(xmlhttp.status == 200)   //Om allt gick bra, hantera datan:
        {
            var jsonData = JSON.parse(xmlhttp.responseText);    //Datan kommer som en sträng, använd json för att skapa ett objekt som håller datan istället
            
            document.getElementById(content_ID).innerHTML = ""; //Töm utifall det finns nått innehåll
            
            jsonData.soklista.sokdata.forEach(placeSearchData); //Placera data på sidan           
        }
        else printReturnInfo(xmlhttp);  //Om den får ett annat returvärde, skriv ut info om detta
    };

    //Skicka requesten:
    xmlhttp.open("GET", request, true);
    xmlhttp.send();
});

function placeSearchData(data)  //Placerar data som sökts efter på sidan
{
    var element = document.getElementById(content_ID);

    element.innerHTML += "<h3>" + data.namn + "</h3>";
    element.innerHTML += "<h4>" + "Antal platsannonser: " + data.antal_platsannonser + "</h4>";
    element.innerHTML += "<h4>" + "Antal lediga jobb:" + data.antal_ledigajobb + "</h4>";
    element.innerHTML += "<h4>" + "ID: " + data.id + "</h4>";
    element.innerHTML += "<h4>" + "Namn: " + data.namn + "</h4>";
    
    element.innerHTML += "<hr>";    //Skriv en indelningslinje
}
