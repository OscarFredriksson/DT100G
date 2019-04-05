<?php
    /*
    *   Denna fil innehåller klassen för ett Quiz
    *
    *   Klassens syfte är att hålla all data för ett quiz, detta innebär alla dess
    *   frågor + alternativ, mm, samt att ha funktioner som behövs
    *
    *   All kod är skriven av Oscar Fredriksson   
    */


    //Inkludera databas-klassen för att kunna använda denna för att hämta data
    require_once "database/database.php";

    class Quiz
    {
        private $id;
        private $questions = Array();
        private $activeQuestion;

        private $database;

        private $finished = false;

        function __construct($id)
        {
            $this->id = $id;
            
            $this->database = new Database();

            $result = $this->database->get_all_questions($this->id);
            
            foreach($result as $question)
            {                
                $this->questions[] = $question;
            }
            $this->activeQuestion = 0;
        }

        function reconnect_to_DB()
        {
            $this->database->connect();
        }

        function getTitle()
        {
            return $this->database->get_quiz_title($this->id);
        }

        function placeQuestion()
        {
            echo $this->questions[$this->activeQuestion]->getQuestion();
        }

        function placeAlternatives()
        {
            $alternatives = $this->questions[$this->activeQuestion]->getAlternatives();

            foreach($alternatives as $alternative)
            {
                echo '<input type="button" class="button alternative hover-highlight no-select-mark"';
                echo 'onClick="checkAnswer(' . $alternative->is_correct . ',this)"';
                echo "id='" . $alternative->is_correct . "'";
                echo 'value="' . $alternative->text . '">';
            }
        }

        function placeResultBoxes()
        {
            $i = 1;

            foreach($this->questions as $question)
            {
                echo '<button class="button hover-highlight no-select-mark" 
                        onClick="showAnswer(' . "'" . $question->text . "','" . $question->getAnswer()->text . "'";
                        
                if(!$question->getAnswer()->is_correct) echo ",'" . $question->getCorrectAnswer()->text . "'";
                
                echo ')">';
                                
                echo '<i class="material-icons icon';
                
                if($question->getAnswer()->is_correct)  echo ' correct"> check_circle';
                else                                    echo ' wrong"> error';
                
                echo '</i>' . "Fråga " . $i . '</button>';

                $i++;
            }
        }

        function nextQuestion()
        {
            $this->activeQuestion++;
            
            if($this->activeQuestion > (sizeof($this->questions) - 1))
                $this->finished = true;
        }

        function isFinished()
        {
            return $this->finished;
        }

        function isLastQuestion()
        {
            if($this->activeQuestion >= (sizeof($this->questions) - 1)) return true;
            else                                                        return false;
        }

        function getNumberOfQuestions()
        {
            return sizeof($this->questions);
        }

        function setQuestion($nr)
        {
            $this->activeQuestion = $nr;
        }

        function getCurrent()
        {
            return $this->activeQuestion;
        }

        function getQuestions()
        {
            return $this->questions;
        }

        function addAnswer($text, $is_correct)
        {
            $this->questions[$this->activeQuestion]->addAnswer(new Alternative($text, $is_correct));
        }

        function getQuestionsLeft()
        {
            return sizeof($this->questions) - $this->activeQuestion;
        }
    }

?>