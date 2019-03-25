<?php
    class Builder
    {  
        private $location;

        function __construct($location)
        {
            $this->location = $location;
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
            echo "<div class='wrapper'> <header> 
    
                    <a class='header-title' href='index'> Projekt - Quiz </a>

                </header>
                <div id='content' class='content'>";
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
            echo '<i class="material-icons icon">more_vert</i></div>';

            echo '<p class="descr">' . $descr . '</p>';
                    
            echo '  <div class="lower">
                        <input type="button" class="play-btn hover-highlight" value="spela" onclick="playButtonClicked(this)" id="' . $id . '">
                    </div> </div></li>';
        }
    }

?>