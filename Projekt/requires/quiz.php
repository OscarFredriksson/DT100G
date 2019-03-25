<?php
    require_once "database/database.php";

    class Quiz
    {
        private $id;
        private $questions = Array();
        private $activeQuestion;

        private $database;

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

        function placeQuestion()
        {
            echo '<div class="question"><h1>'; 
            
            //echo $this->questions[$this->activeQuestion]->getQuestion();
            
            echo $this->database->get_question($this->questions[$this->activeQuestion]);

            echo '</h1></div>';

            $this->placeAlternatives();
        }

        function placeAlternatives()
        {
            echo '<div class="alternatives">';

            $alternatives = $this->database->get_all_alternatives($this->questions[$this->activeQuestion]);

            foreach($alternatives as $alternative)
            {
                echo '<input type="button" class="alternative hover-highlight" onClick="checkAnswer(this)"';

                echo "id='" . $alternative . "'";

                echo 'value="' . $this->database->get_alternative_text($alternative) . '">';
            }

            echo '</div>';
        }

        function nextQuestion()
        {
            $this->activeQuestion++;  
        }

        function isLastQuestion()
        {
            if($this->activeQuestion >= (sizeof($this->questions) - 1)) return true;
            else                                                        return false;
        }

        function setQuestion($nr)
        {
            $this->activeQuestion = $nr;
        }

        function getCurrent()
        {
            return $this->activeQuestion;
        }

        function checkAnswer($alternative_ID)
        {
            $is_correct = $this->database->check_answer($alternative_ID);

            //SPARA SPELARENS SVAR TILL DATABAS Å SÅNT HÄR

            return $is_correct;
        }
    }

?>