<?php
    /*
    *   På denna sida skrivs "Om sidan"-text ut
    *
    *   Sidan byggs upp med hjälp av builder-klassen och sedan skrivs "om sidan"-texten
    *   ut som innehåll på sidan.
    *
    *   All kod är skriven av Oscar Fredriksson   
    */

    require_once "requires/builder.php";    //Inkludera hemsidebyggaren för att kunna skapa ett objekt av denna

    $builder = new Builder("about");    //Skapa en ny hemsidebyggare

    $builder->placeHead();          //Be byggaren placera ut hemsidans <head> där bland annat CSS filen inkluderas
    $builder->placeHeader();        //Be byggaren placera ut hemsidans header med navigeringslänkar
    $builder->placePageStart();     //Be byggaren placera ut starten på hemsidan så denna sedan kan fyllas med quiz-boxarna 
?>

<!--Skapa en lista för varje rad med information på sidan-->
<ul class="about">
    <li> <!--En rad i listan med text-->
        <p> Den här sidan skapades under våren 2019 som projekt i kursen DT100G - Webbprogrammering på Mittuniversitetet.  </p>     
    </li>
    <li> 
        <p> Tanken med sidan var att skapa en platform där olika quiz kan läggas ut som sedan kan spelas av sidans besökare. </P> 
    </li>
    <li> 
        <p> All kod är skriven av Oscar Fredriksson (osfr1701@student.miun.se) '
    </li>
</ul>

<?php
    $builder->placePageEnd();   //Placera ut hemsidans slut på innehållet
    $builder->placeFooter();    //Placera ut sidans footer
?>