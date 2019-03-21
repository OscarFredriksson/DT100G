<?php
    require "requires/quiz.php";

    $website = new Quiz();
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Sniglet|Open+Sans">
        
        <title> Quiz </title>
    </head>

    <body>
        <?php $website->placeHeader(); ?>

        <div class="content">
            <div class="question">
                <h1> Frågan här... </h1>
            </div>

            <div class="alternatives">
                <input class="alternative" value="Alternativ 1">

                <input class="alternative" value="Alternativ 2">
                
                <input class="alternative" value="Alternativ 3">
                
                <input class="alternative" value="Alternativ 4">

            </div>
        <div>

        <?php $website->placeFooter(); ?>
    </body>

    <?php $website->importScript(); ?>
</html>