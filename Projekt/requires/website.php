<?php
    class Website
    {  
        function placeHead()
        {
            echo '<head>
                    <meta charset="utf-8">
                    <link rel="stylesheet" type="text/css" href="css/style.css">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Sniglet|Open+Sans">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

                    <title> Quiz </title>
                </head>';
        }

        function placeHeader()
        {
            echo "<header>
    
                    <a class='header-title' href='index.php'> Projekt - Quiz </a>

                </header>";
        }

        function placeFooter()
        {
            echo "<footer> <ul> 
                    <li>Oscar Fredriksson</li>
                    <li>osfr1701@student.miun.se</li>
                    <li id='lastModified'>Senast ändrad: ";
                             
                    setlocale(LC_ALL, "sv_SE");

                    echo strftime("%e %B %Y %H:%M:%S", $this->get_last_modified()); 
                             
            echo "</li> </ul> </footer>";
        }

        function importScript()
        {
            echo '<script src="js/main.js"></script>';
        }

        private function get_last_modified() 
        { 
            $incls = get_included_files(); 
            $incls = array_filter($incls, "is_file"); 
            $mod_times = array_map('filemtime', $incls); 
            $mod_time = max($mod_times); 

            return $mod_time; 
        } 
    }

?>
