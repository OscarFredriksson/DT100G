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
            echo '<i class="material-icons icon no-select-mark" onclick="deleteQuiz(' . $id . ')">delete</i></div>';

            echo '<p class="descr">' . $descr . '</p>';
                    
            echo '  <div class="lower">
                        <input type="button" class="play-btn hover-highlight no-select-mark" value="spela" onclick="playButtonClicked(this)" id="' . $id . '">
                    </div> </div></li>';
        }

        function create_result_popup_box()
        {
            //(Fylls med hjälp av javascript)

            echo '<div id="popup" class="popup">

                <div class="box">
                    <i class="material-icons close" id="close">close</i>
                    <div class="content" id="popup-content">
                    </div>
                </div>

            </div>';
        }

        function create_play_page()
        {
            echo '<div class="question"><h1 id="question-text"></h1>';
            
            echo '<div class="alternatives" id="alternatives"></div>';

            echo '<div class="questions-left"> <p id="questions-left"></p> </div>';

            echo '<progress id="progress-bar" class="bar" max="1" value="0"></div>';
        }

        function place_create_quiz_page()
        {
            echo '<h1 class="title">Skapa nytt quiz </h1>';

            echo '<div class="create-quiz"><form method="post">';

            echo '
                        <div class="row">
                            <label> Titel: </label>
                            <input type="text" placeholder="Titel">
                        </div>';

            echo '
                    <div class="row">
                        <label> Beskrivning: </label>
                        <textarea type="text" placeholder="Beskrivning" rows="2"></textarea>
                    </div>
                ';
            
            echo ' <hr> ';

            echo '
                    <ul class="questions" id="questions-list"> 
                        <li>
                            <h2> Fråga 1: </h2>
                            <div class="row">
                                <label> Fråga: </label>
                                <input type="text" placeholder="Fråga">
                            </div>
                        </li>
                        <li>
                            <label> Alternativ: </label>
                            <input class="alternative" type="text" placeholder="Alternativ 1">
                            <input class="alternative" type="text" placeholder="Alternativ 2">
                            <input class="alternative" type="text" placeholder="Alternativ 3">
                            <input class="alternative" type="text" placeholder="Alternativ 4">
                        </li>
                    </ul>


                    <button class="button add-question-btn" onclick="addQuestion()"> Lägg till en till fråga </button>
                ';

            echo ' <hr> ';

            echo '<button type="submit" class="button"> Skapa Quiz </button></form></div>';
        }

        function build_new_question_form()
        {

        }
    }

?>
