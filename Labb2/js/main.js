"use strict";

var baseURL = "http://api.arbetsformedlingen.se/af/v0";

//
// Wait for DOM to load
document.addEventListener("DOMContentLoaded", function(){ 
    var xmlhttp = new XMLHttpRequest();

//
// Read all LÃ„N and dynamically create list from AF
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {

                var jsonData = JSON.parse( xmlhttp.responseText );
                document.getElementById("searchlan").innerHTML = "";
                for(var i=0; i < jsonData.soklista.sokdata.length; i++){
                   document.getElementById("mainnavlist").innerHTML += "<li id='"+jsonData.soklista.sokdata[i].id+"'>"+jsonData.soklista.sokdata[i].namn+" (" + jsonData.soklista.sokdata[i].antal_ledigajobb + ")</li>";    
                   document.getElementById("searchlan").innerHTML += "<option value='"+jsonData.soklista.sokdata[i].id+"'>"+jsonData.soklista.sokdata[i].namn+"</option>";      
                }
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('something else other than 200 was returned');
           }
        }
    };

    xmlhttp.open("GET", baseURL+"/platsannonser/soklista/lan", true);
    xmlhttp.send();
}); 

//
// Create eventlistener for clicks on dynamically created list of LÃ„N in mainnavlist
document.getElementById('mainnavlist').addEventListener("click", function(e){
    alert("Du har valt lÃ¤n med id "+e.target.id);
}); 