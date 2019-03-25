<?php
    require "requires/builder.php";

    $builder = new Builder("result");

    $builder->placeHead();

    $builder->placeHeader();
?>
 
    <h1> RESULTAT HÄR </h1>

<?php
    $builder->placeFooter();
?>