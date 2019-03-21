<?php
    require "requires/quiz.php";
    require "requires/quizbox.php";

    $website = new Quiz();
    $box = new QuizBox(1);

?>

<!DOCTYPE html>
<html lang="sv">
    <?php $website->placeHead(); ?>

    <body>
        <?php $website->placeHeader(); ?>

        <ul class="quiz-list">

            <?php 
                $box->place();
            ?>
        </ul>

        <?php 
            $website->placeFooter();
            $website->importScript(); 
        ?>
    </body>
</html>