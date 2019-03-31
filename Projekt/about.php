<?php

    require_once "requires/builder.php";

    $builder = new Builder("about");

    $builder->placeHead();
    $builder->placeHeader();
    $builder->placePageStart();


    $builder->placePageEnd();
    $builder->placeFooter();


?>