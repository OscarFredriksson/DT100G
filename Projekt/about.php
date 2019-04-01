<?php

    require_once "requires/builder.php";

    $builder = new Builder("about");

    $builder->placeHead();
    $builder->placeHeader();
    $builder->placePageStart();
?>

<ul class="about">
    <li> <p> Den här sidan skapades under våren 2019 som projekt i kursen DT100G - Webbprogrammering på Mittuniversitetet.  </p> </li>
    <li> <p> Tanken med sidan var att skapa en platform där olika quiz kan läggas ut som sedan kan spelas av sidans besökare. </P> </li>
    <li> <p> All kod är skriven av Oscar Fredriksson (osfr1701@student.miun.se) </li>
</ul>

<?php
    $builder->placePageEnd();
    $builder->placeFooter();
?>