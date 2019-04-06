<?php
    /*
    *   Detta är en klass för att dynamiskt bygga upp hemsidans olika sidor
    *
    *   Klassen innehåller funktioner för att bygga upp gemensamma element som t.ex
    *   sidans header och footer.
    *
    *   All kod är skriven av Oscar Fredriksson   
    */

    Interface BuilderInterface
    {
        //Plocka in vilken sida den är på, samt alternativt en quiz-titel att placera i headern
        function __construct($location, $title = "");

        function placeHead();   //Placera ut sidans <head> 	

        function placeHeader();     //Placera ut sidans header
        function placeFooter();     //Placera ut sidans footer

        function importScript();    //Importera javascript-filen för sidan

        function placePageStart();  //Placera starten på sidans innehåll
        function placePageEnd();    //Placera slutet på sidans innehåll

        function create_quiz_box($id, $title, $descr);  //Bygg en quizbox (de som visas på index-sidan) av inargumenten

        function create_play_page();    //Placera innehållet för play-sidan

        function create_result_popup_box(); //Bygg en popup-box för resultatsidan
    }

    class Builder implements BuilderInterface
    {  
        private $location;  //Vilken sida byggaren är för (t.ex index)
        private $title;     //Om det är quizsidan sparas dess titel

         //Plocka in vilken sida den är på, samt alternativt en quiz-titel att placera i headern
        function __construct($location, $title = "")   
        {
            $this->location = $location;
            $this->title = $title;
        }

        function placeHead()    //Placera ut sidans <head> 	
        {
            echo '<!DOCTYPE html><html lang="sv">';
            echo '<head>';
            echo '<meta charset="utf-8">';
            echo '<link rel="stylesheet" type="text/css" href="css/style.css">';
            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Sniglet|Open+Sans">'; //Importera typsnitt från Googles API
            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">';  //Importera ikoner från Googles API
            echo '<link rel="icon" href="icons/question_icon.png">';    //Sätt en ikon som visas i tabb-fliken
            echo '<title> Quiz </title>';
            echo '</head><body>';
        }

        function placeHeader()  //Placera ut sidans header
        {
            echo '<div class="wrapper">';   //Allt innehåll på sidan placeras inom en wrapper
            
            echo '<header><ul>';    //Använder en lista för headerns innehåll

            echo '<li ';
            if($this->location == "index") echo 'class="active"';   //Placera en CSS-klass för den aktiva sidan så en markör kan appliceras för denna
            echo '><a href="index.php"> Quizspel </a></li>';
            
            echo '<li ';
            if($this->location == "play") echo 'class="active"';
            echo '><p>' . $this->title . '</p></li>';
            
            echo '<li ';
            if($this->location == "about") echo 'class="active"';
            echo '><a href="about.php"> om sidan </a></li>';

            echo '</ul></header>';
        }

        function placePageStart()   //Placera starten på sidans innehåll
        {
            //Själva innehållet på sidan (allt utom header och footer) placeras inom denna tagg
            echo '<div class="content">';   

            switch($this->location) 
            {
                //Några sidor som kräver placering av extra element för dess innehåll
                case "index":   echo '<h1> Välj ett quiz att spela: </h1>';
                                echo '<ul class="quiz-list">'; 
                                break;
                case "result":  echo '<div class="result">';
                                echo '<h1> Resultat </h1>';
                                echo '<div class="questions">';
                                break;
            }
        }

        function placePageEnd() //Placera slutet på sidans innehåll
        {
            switch($this->location)
            {
                //Stäng taggar för de element som kräver extra element
                case "index":   echo '</ul>';
                                break;
                case "result":  echo '</div>';
                                echo '<a href="index.php" class="button">Avsluta</a>';
                                echo '</div>';
                                break;
            }

            echo '</div>';  //Stäng content taggen
        }

        function placeFooter()  //Placera sidans footer
        {
            echo '<footer> <ul>'; //Använder en lista för footerns innehåll
            echo '<li>Oscar Fredriksson</li>';

            //Mailto länk som öppnar användarens mailprogram när den klickas
            echo '<li><a href="mailto:osfr1701@student.miun.se">osfr1701@student.miun.se</a></li>';
            
            //Använder funktionen get_last_modified för att skriva ut när sidan senast ändrades
            echo '<li id="lastModified">Senast ändrad: ';
            setlocale(LC_ALL, "sv_SE");
            echo strftime("%e %B %Y %H:%M:%S", $this->get_last_modified()); 
            echo "</li> </ul> </footer></div>";
            
            $this->importScript();  //Importera javascript-fil för sidan
            
            echo "</body></html>";
        }

        private function get_last_modified()   //När någon fil i projektet senast var ändrad (används i footer koden)
        { 
            //Returnerar när något på sidan senast ändrades
            $incls = get_included_files();
            $incls = array_filter($incls, "is_file"); 
            $mod_times = array_map('filemtime', $incls); 
            $mod_time = max($mod_times); 

            return $mod_time; 
        }       

        function importScript() //Importera javascript-filen för sidan
        {
            $script = 'js/' . $this->location . '.js';  //Bygg ihop filvägen till filen

            if(!file_exists($script)) return;   //Om filen inte finns, gå ur funktionen

            echo'<script src="' . $script . '"></script>';

        }

        function create_quiz_box($id, $title, $descr)   //Bygg en quizbox (de som visas på index-sidan) av inargumenten
        {
            //Varje quizbox läggs in i en lista på sidan, därav <li>-taggen
            echo '<li><div class="quizbox"> <div class="upper">';
            echo '<p class="title">' . $title . '</p>';
            echo '</div>';

            echo '<p class="descr">' . $descr . '</p>';
                    
            echo '<div class="lower">';

            /*
            *   När knappen klickas på, kör funktionen playButtonClicked i javascript-filen, 
            *   skicka in objektet för att kunna plocka dess ID
            */
            echo '<button type="button" class="button play-btn" onclick="playButtonClicked(this)" id="' . $id . '">';
            echo 'Spela';
            echo '</button>';
            echo '</div> </div></li>';
        }

        function create_play_page() //Placera innehållet för play-sidan
        {
            echo '<div class="question">';  //Wrapper för 

            echo '<h1 id="question-text"></h1>';  //Tagg för frågetexten
            
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
