<?php
    session_start();
    session_unset();
    session_destroy();
    
    require_once "requires/builder.php";
    require_once "requires/database/database.php";

    $builder = new Builder("index");

    $builder->placeHead();
    $builder->placeHeader();
    $builder->placePageStart();
 
    $database = new Database();
    
    $quizzes = $database->get_all_quizzes();

    foreach($quizzes as $quiz)
    {
        $title = $database->get_quiz_title($quiz);
        $descr = $database->get_quiz_descr($quiz);
        $builder->create_quiz_box($quiz, $title, $descr);
    } 

    $builder->placePageEnd();
    $builder->placeFooter();
?>