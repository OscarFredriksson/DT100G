<?php
    require_once "requires/builder.php";
    require_once "requires/database/database.php";

    $builder = new Builder("index");

    $builder->placeHead();

    $builder->placeHeader();

?>

<ul class="quiz-list">

    <li><i class="material-icons add-icon no-select-mark">add_circle_outline</i></li>
        
    <?php 
    $database = new Database();
    
    $quizzes = $database->get_all_quizzes();

    foreach($quizzes as $quiz)
    {
        $title = $database->get_quiz_title($quiz);
        $descr = $database->get_quiz_descr($quiz);
        $builder->create_quiz_box($quiz, $title, $descr);
    } 
    ?>
</ul>

<?php
    $builder->placeFooter();
?>