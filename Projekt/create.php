<?php
    require_once "requires/builder.php";

    $builder = new Builder("create");

    $builder->placehead();

    $builder->placeHeader();

    $builder->place_create_quiz_page();

    $builder->placeFooter();

?>