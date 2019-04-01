<?php
    class Builder
    {  
        private $location;
        private $title;

        function __construct($location, $title = "")
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
            echo '<div class="wrapper">';
            echo '<header><ul>';

            echo '<li ';
            if($this->location == "index") echo 'class="active"';
            echo '><a href="index"> Quizspel </a></li>';
            
            echo '<li ';
            if($this->location == "quiz") echo 'class="active"';
            echo '><p>' . $this->title . '</p></li>';
            
            echo '<li ';
            if($this->location == "about") echo 'class="active"';
            echo '><a href="about"> om sidan </a></li>';

            echo '</ul></header>';
        }

        public function placePageStart()
        {
            echo '<div class="content">';

            switch($this->location)
            {
                case "index":   echo '<h1> Välj ett quiz att spela: </h1>';
                                echo '<ul class="quiz-list">'; 
                                break;
                case "result":  echo '<div class="result">';
                                echo '<h1> Resultat </h1>';
                                echo '<div class="questions">';
                                break;
                case "about":   break;
            }
        }

        public function placePageEnd()
        {
            switch($this->location)
            {
                case "index":   echo '</ul>';
                                break;
                case "result":  echo '</div>';
                                echo '<a href="index" class="button">Avsluta</a>';
                                echo '</div>';
                                break;
                case "about":   break;
            }

            echo '</div>';
        }

        function placeFooter()
        {
            echo '<footer> <ul> 
                    <li>Oscar Fredriksson</li>
                    <li><a href="mailto:osfr1701@student.miun.se">osfr1701@student.miun.se</a></li>
                    <li id="lastModified">Senast ändrad: ';
                             
                    setlocale(LC_ALL, "sv_SE");

                    echo strftime("%e %B %Y %H:%M:%S", $this->get_last_modified()); 
                             
            echo "</li> </ul> </footer></div>";
            
            $this->importScript(); 
            
            echo "</body></html>";
        }

        function importScript()
        {
            $script = 'js/' . $this->location . '.js';

            if(!file_exists($script)) return;

            echo'<script src="' . $script . '"></script>';

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

        function create_result_popup_box()
        {
            //(Fylls med hjälp av javascript)
            echo '<div id="popup" class="popup">
                    <div class="box">
                        <i class="material-icons close" id="close">close</i>
                        <div class="popup-content" id="popup-content">
                        </div>
                    </div>
                </div>';
        }
        
    }

?>
