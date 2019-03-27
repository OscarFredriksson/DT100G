<?php
    require "requires/builder.php";
    require_once "requires/quiz.php";

    session_start();

    $builder = new Builder("result");

    $builder->placeHead();

    $builder->placeHeader();

    if(empty($_SESSION['quiz']))    Header("Location: index");
    else                            
    {
        $quiz = $_SESSION['quiz'];
        $quiz->reconnect_to_DB();
    }

    $quiz->createResultPage();

    echo '<div id="popup" class="popup">

            <div class="box">
                <i class="material-icons close" id="close">close</i>
                <div class="content" id="popup-content">
                </div>
            </div>

        </div>';

    $builder->placeFooter();
?>