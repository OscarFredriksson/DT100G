<?php
    /*
    *   Denna fil innehåller klassen för ett Quiz
    *
    *   Klassens syfte är att hålla all data för ett quiz, detta innebär alla dess
    *   frågor + alternativ, title, beskrivningstext, mm, samt att ha de funktioner 
    *   som behövs för att utföra nödvändiga operationer på denna data, t.ex gå till 
    *   nästa fråga, placera ut frågan + alternativ, mm.    
    *
    *   All kod är skriven av Oscar Fredriksson   
    */

    //Inkludera databas-klassen för att kunna använda denna för att hämta data
    require_once "database/database.php";

    interface QuizInterface
    {
        function __construct($id);   //Konstruera quiz med givet ID
   
        /*
        *   När en instans av klassen skickas mellan filer med hjälp av sessioner
        *   tappas uppkopplingen till databasen, denna funktion återställer den
        */
        function reconnect_to_DB();

        function getTitle();    //Hämta quizzets titel
        function getDescr();    //Hämta quizzets beskrivningstext

        function placeQuestion();       //Placera ut frågetexten
        function placeAlternatives();   //Placera ut alternativ-knapparna

        function isFinished();      //Kolla om quizzet är färdigspelat
        function nextQuestion();    //Gå till nästa fråga

        function getNumberOfQuestions();    //Hämta hur många frågor quizzet har
        
        function addAnswer($text, $is_correct); //Lägg till användarens svar för nuvarande fråga
        
        function getQuestionsLeft();    //Hämta hur många frågor det är kvar
        
        function placeResultButtons();  //Placera ut knapparna för resultatet på varje fråga
    }

    class Quiz implements QuizInterface
    {
        private $id;    //Quizzets ID
        private $title; //Quizzets titel
        private $descr; //Quizzets beskrivningstext

        private $finished = false;  //Om quizzet är färdigspelat eller ej
        
        private $questions = Array();   //En lista med alla quizzets frågor
        
        /*
        *   Den nuvarande frågan, alltså den fråga som visas som 
        *   på skärmen för användaren. Variabeln håller indexet till
        *   frågan i listan med frågor, börja på indexet för första frågan
        */
        private $currentQuestion = 0;

        private $database;  //Objekt för quizzets databas


        function __construct($id)   //Konstruera quiz med givet ID
        {
            $this->id = $id;    //Spara ID't    

            $this->database = new Database();   //skapa en ny databas för quizzet

            $this->title = $this->database->get_quiz_title($this->id);  //Hämta och spara titeln från databasen
            $this->descr = $this->database->get_quiz_descr($this->id);  //Hämta och spara beskrivningstexten från databasen

            $this->questions = $this->database->get_all_questions($this->id); //Hämta alla frågor från databasen
        }

        /*
        *   När en instans av klassen skickas mellan filer med hjälp av sessioner
        *   tappas uppkopplingen till databasen, denna funktion återställer den
        */
        function reconnect_to_DB()
        {
            $this->database->connect(); //använd databasklassens funktion för att ansluta
        }

        function getTitle() //Hämta quizzets titel
        {
            return $this->title;
        }

        function getDescr() //Hämta quizzets beskrivningstext
        {
            return $this->descr;
        }

        function placeQuestion()    //Placera ut frågetexten
        {
            //Hämta nuvarande fråga från listan och placera ut dess text
            echo $this->questions[$this->currentQuestion]->getText();
        }

        function placeAlternatives()    //Placera ut alternativ-knapparna
        {
            //Hämta alla alternativ för nuvarande fråga
            $alternatives = $this->questions[$this->currentQuestion]->getAlternatives();

            //Loopa igenom dessa
            foreach($alternatives as $alternative)
            {
                /*
                *   Bygg ihop HTML-elementet för alternativknappen.
                *   Sätt dess onCLick funktion till checkAnswer funktionen och 
                *   skicka in om svaret är korrekt eller ej, samt själva HTML-elementet
                */
                echo '<input type="button" class="button alternative"';
                echo 'onClick="checkAnswer(' . $alternative->is_correct . ',this)"';
                echo 'value="' . $alternative->text . '">';
            }
        }

        function isFinished()   //Kolla om quizzet är färdigspelat
        {
            return $this->finished;
        }

        function nextQuestion() //Gå till nästa fråga
        {
            $this->currentQuestion++;   //Öka på räknaren för vilken fråga vi är på

            //Om räknaren har gått längre än sista frågan i listan är quizzet färdigspelat
            if($this->currentQuestion > (sizeof($this->questions) - 1))
            {
                $this->finished = true;
            }
        }

        function getNumberOfQuestions() //Hämta hur många frågor quizzet har
        {
            return sizeof($this->questions);
        }

        function addAnswer($text, $is_correct)  //Lägg till användarens svar för nuvarande fråga
        {
            //Lägg till användarens svar till nuvarande fråga, använd alternativklassen för detta
            $this->questions[$this->currentQuestion]->addAnswer(new Alternative($text, $is_correct));
        }

        function getQuestionsLeft() //Hämta hur många frågor det är kvar
        {
            return sizeof($this->questions) - $this->currentQuestion;
        }

        function placeResultButtons()   //Placera ut knapparna för resultatet på varje fråga
        {
            $i = 1; //Räknare för frågorna

            foreach($this->questions as $question)  //Gå igenom alla frågor
            {
                /*
                *   Bygg ihop HTML-elementet för en knapp för frågans resultat.
                *   Sätt dess onClick funktion till att köra showAnswer funktionen i javascript-filen.
                *   I denna skickas frågans text, det valda alternativets text samt möjligtvis det korrekta
                *   alternativets text in. 
                *
                *   Som knappens innehåll placeras en ikon för om svaret var rätt eller ej, samt frågans nummer,
                *   t.ex "Fråga 2". 
                */
                echo '<button class="button"';
                echo 'onClick="showAnswer(' . "'" . $question->getText() . "','" . $question->getAnswer()->text . "'";
                        
                //Om svaret inte är korrekt, skicka även med rätt svar in i funktionen
                if(!$question->getAnswer()->is_correct) echo ",'" . $question->getCorrectAlternative()->text . "'";
                
                echo ')">';
                                
                //Skapa en ikon som placeras i knappen
                echo '<i class="material-icons icon';
                
                //Placera relevant ikon beroende på om svaret är rätt eller ej
                if($question->getAnswer()->is_correct)  echo ' correct"> check_circle';
                else                                    echo ' wrong"> error';
                
                echo '</i>' . "Fråga " . $i . '</button>';  //Skriv ut frågans nummer (t.ex "Fråga 2")

                $i++;
            }
        }
    }

?>