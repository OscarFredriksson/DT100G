<?php
    require "requires/website.php";
    require "requires/quizbox.php";
    require "requires/database.php";

    $website = new Website();

    $database = new Database();
    
    $quizzes = $database->get_all_quizzes();

    $boxes = Array();
    foreach($quizzes as $quiz)
    {
        $boxes[] = new QuizBox($quiz[0], $quiz[1], $quiz[2]);
    }
?>

<!DOCTYPE html>
<html lang="sv">
    <?php $website->placeHead(); ?>

    <body>
        <?php $website->placeHeader(); ?>

        <ul class="quiz-list">

            <li><i class="material-icons add-icon">add_circle_outline</i></li>

            <?php
                foreach($boxes as $box) $box->place();
            ?>
        </ul>

        <?php 
            $website->placeFooter();
            $website->importScript(); 
        ?>
    </body>
</html>