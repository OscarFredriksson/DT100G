<?php
    class Builder
    {  
        private $location;

        private $title;

        function __construct($location, $title)
        {
            $this->location = $location;
            $this->title = $title;
        }

        function placeHead()
        {
            echo '<!DOCTYPE html><html lang="sv">
                <head>
                    <meta charset="utf-8">
                    <link rel="stylesheet" type="text/css" href="css/style.css">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Sniglet|Open+Sans">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
                    <link rel="icon" href="icons/question_icon.png">

                    <title> Quiz </title>
                </head><body>';
        }

        function placeHeader()
        {
            echo '<div class="wrapper"> <header>';
    
            echo '<a class="header-title" href="index"> Projekt - Quiz </a>';

            echo '<p>' . $this->title . '</p>';

            echo '<p> about </p>';

            echo '</header><div id="content" class="content">';
        }

        function placeFooter()
        {
            echo "</div> <footer> <ul> 
                    <li>Oscar Fredriksson</li>
                    <li>osfr1701@student.miun.se</li>
                    <li id='lastModified'>Senast ändrad: ";
                             
                    setlocale(LC_ALL, "sv_SE");

                    echo strftime("%e %B %Y %H:%M:%S", $this->get_last_modified()); 
                             
            echo "</li> </ul> </footer> </div>";
            
            $this->importScript(); 
            
            echo "</body></html>";
        }

        function importScript()
        {
            echo'<script src="js/' . $this->location . '.js"></script>';

        }

        private function get_last_modified() 
        { 
            $incls = get_included_files(); 
            $incls = array_filter($incls, "is_file"); 
            $mod_times = array_map('filemtime', $incls); 
            $mod_time = max($mod_times); 

            return $mod_time; 
        }

        function create_quiz_box($id, $title, $descr)
        {
            echo '<li><div class="quizbox"> <div class="upper">';
            echo '<p class="title">' . $title . '</p>';
            echo '</div>';

            echo '<p class="descr">' . $descr . '</p>';
                    
            echo '<div class="lower">';
            echo    '<button type="button" class="button play-btn" onclick="playButtonClicked(this)" id="' . $id . '">
                        Spela
                    </button>';
            echo '</div> </div></li>';
        }

        function create_play_page()
        {
            echo '<div class="question"><h1 id="question-text"></h1>';
            
            echo '<div class="alternatives" id="alternatives"></div>';
            echo '<div class="questions-left"> <p id="questions-left"></p> </div>';
            echo '<progress id="progress-bar" class="bar" max="1" value="0"></div>';
        }
    }

?>
