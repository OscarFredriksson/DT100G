<?php
    /*
    *   Denna fil innehåller en klass för projektets databas
    *
    *   Klassens syfte är att hämta värden från projektets databas, detta görs
    *   genom att skapa ett objekt av klassen och sen köra medlemsfunktionen 
    *   (t.ex "get_all_quizzes") för det man vill hämta. 
    *
    *   All kod är skriven av Oscar Fredriksson   
    */


    /*
    *   Inkludera fråge- och alternativklassen för att kunna bygga objekt av dessa 
    *   som sedan skickas som returvärde mm. 
    */
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Projekt/requires/question.php";  

    class Database
    {
        private $conn;  //Variabel för databasens uppkopplingsobjekt

        public function connect()   //Anslut till databasen
        {
            //Skapa en ny uppkoppling och tilldela till uppkopplingsvariabeln
            $this->conn = new mysqli('localhost', 'root', '', 'quiz', 3306);
            
            mysqli_set_charset($this->conn,"utf8"); //Sätt charset till UTF8 för att fixa åäö
            
            if ($this->conn->connect_error) //Om någonting gick fel med uppkopplingen
            {
                die("Connection failed: " . $this->conn->connect_error);    //Avsluta och skriv ut felet
            }     
        }

        /*
        *   En funktion för att skicka en SQL-query till databasen, funktionen
        *   returnerar databasens svar.
        */
        private function sendQuery($query)
        {        
            $this->connect();   //Koppla upp till databasen

            /*
            *   Använd prepare för att skydda mot SQL-injektion, om tilldelningen till $stmt variabeln
            *   misslyckas hittade prepare-funktionen något fel i SQL-queryn, isåfall skriv ut felmeddelandet
            */
            if(!$stmt = $this->conn->prepare($query))
            {
                die("Error: " . $this->conn->error);
            }
            
            $stmt->execute();   //Skicka SQL-queryn till databasen
            
            if(!$result = $stmt->get_result())  //Hämta databasens svar, om det misslyckas, skriv ut felmeddelande
            {
                die("Error:" . $this->conn->error);
            }
            else    //Annars, stäng kopplingen till databasen och returnera resultatet
            {
                $this->conn->close();
                return $result;
            }
        }

        //Kolla om ett quiz existerar med givet ID, returnerar true eller false
        public function quiz_exists($quiz_ID)   
        {
            //SQL-query för att hämta första raden med givet ID
            $query = "SELECT 1 FROM QUIZZES WHERE QUIZ_ID = " . $quiz_ID;
                
            $result = $this->sendQuery($query); //Skicka queryn till databasen

            if(mysqli_num_rows($result) == 0)   return false;   //Om den inte får någon rad tillbaka finns inte quizzet
            else                                return true;    //Om den får 1 rad tillbaka finns quizzet
        }

        //Hämta alla quiz från databasen, ID't för alla quiz returneras i en lista
        public function get_all_quizzes()
        {
            //SQL-query för att hämta alla värden i kolumnen QUIZ_ID från tabellen QUIZZES
            $query = "SELECT QUIZ_ID FROM QUIZZES";
                
            $result = $this->sendQuery($query); //Skicka queryn till databasen

            $quizzes = Array(); //Skapa en lista för alla quiz

            while($row = $result->fetch_assoc())    //Gå igenom varje rad som SQL-queryn fick som svar
            {
                $quizzes[] = $row["QUIZ_ID"];   //Lägg till QUIZ_ID-värdet från raden till listan
            }

            return $quizzes;    //När den har gått igenom alla, returnera listan
        }

        //Hämta titeln för ett quiz med givet ID
        public function get_quiz_title($quiz_ID)
        {
            /*
            *   SQL-query för att hämta titeln från raden med det givna quiz ID't, 
            *   begränsa sökningen till 1 rad för att spara tid
            */
            $query = "SELECT TITLE FROM QUIZZES WHERE QUIZ_ID=" . $quiz_ID . " LIMIT 1";

            $result = $this->sendQuery($query); //Skicka queryn till databasen

            return $result->fetch_assoc()["TITLE"]; //Returnera titeln från raden som queryn fick som svar
        }

        //Hämta beskrivningstexten för ett quiz med givet ID
        public function get_quiz_descr($quiz_ID)
        {
            /*
            *   SQL-query för att hämta beskrivningstexten från raden med det givna quiz ID't, 
            *   begränsa sökningen till 1 rad för att spara tid
            */
            $query = "SELECT DESCRIPTION FROM QUIZZES WHERE QUIZ_ID=" . $quiz_ID . " LIMIT 1";

            $result = $this->sendQuery($query); //Skicka queryn till databasen

            return $result->fetch_assoc()["DESCRIPTION"];   //Returnera beskrivningstexten från raden som queryn fick som svar
        }

        //Hämta alla frågor till ett quiz med givet ID
        public function get_all_questions($quiz_ID)
        {
            /*
            *   SQL-query för att hämta alla rader från frågetabellen där quiz_idt 
            *   stämmer överens med inargumentet.
            */
            $query = "SELECT * FROM QUESTIONS WHERE QUIZ_ID=" . $quiz_ID;

            $result = $this->sendQuery($query); //Skicka queryn till databasen

            $questions = Array();   //Skapa en lista för alla fågor

            while($row = $result->fetch_assoc())    //Gå igenom varje rad som queryn fick som svar från databasen
            {
                $question = new Question($row["TEXT"]); //Skapa ett nytt Question-objekt med texten från raden

                $alternatives = $this->get_all_alternatives($row["QUESTION_ID"]);   //Hämta alla alternativ till frågan

                foreach($alternatives as $alternative)  //Gå igenom alla alternativ
                {
                    $question->addAlternative($alternative);    //Lägg till varje alternativ till frågan
                }
                
                $questions[] = $question;   //Lägg till frågan till listan
            }

            return $questions;  //Returnera listan med alla frågor
        }

        //Hämta alla alternativ till en fråga med givet ID
        public function get_all_alternatives($question_ID)  
        {
            /*
            *   SQL-query för att hämta alla rader från alternativtabellen där frågeIDt
            *   stämmer överens med inargumentet.
            */
            $query = "SELECT * FROM ALTERNATIVES WHERE QUESTION_ID=" . $question_ID;

            $result = $this->sendQuery($query); //Skicka queryn till databasen

            $alternatives = Array();    //Skapa en lista för alla alternativ

            while($row = $result->fetch_assoc())    //Gå igenom varje rad som queryn fick som svar från databasen
            {
                /*
                *   Skapa ett nytt Alternative-objekt och skicka in alternativets text, samt
                *   om alternativet är ett korrekt svar eller ej
                */
                $alternatives[] = new Alternative($row["TEXT"], $row["IS_CORRECT"]);    
            }

            return $alternatives;   //Returnera listan med alla alternativ
        }


        /*public function get_question($question_ID)
        {
            $query = "SELECT * FROM QUESTIONS WHERE QUESTION_ID=" . $question_ID;

            $result = $this->sendQuery($query);

            return $result->fetch_assoc()["TEXT"];
        }*/

        /*public function get_alternative_text($alternative_ID)
        {
            $query = "SELECT TEXT FROM ALTERNATIVES WHERE ALTERNATIVE_ID=" . $alternative_ID . " LIMIT 1";

            $result = $this->sendQuery($query);

            return $result->fetch_assoc()["TEXT"];
        }

        public function check_answer($alternative_ID)
        {
            $this->add_answer($alternative_ID);

            $query = "SELECT IS_CORRECT FROM ALTERNATIVES WHERE ALTERNATIVE_ID=" . $alternative_ID . " LIMIT 1";

            $result = $this->sendQuery($query);

            return $result->fetch_assoc()["IS_CORRECT"];
        }

        public function get_correct_answer($question_ID)
        {
            $query = "SELECT QUESTION_ID FROM QUESTIONS WHERE QUESTION_ID=" . $question_ID . "AND IS_CORRECT=1 LIMIT 1";

            $result = $this->sendQuery($query);

            return $result->fetch_assoc()["QUESTION_ID"];
        }*/
    }

?>