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
                        
            echo $this->questions[$this->activeQuestion]->getQuestion();

            echo '</h1></div>';

            $this->placeAlternatives();

            $current = $this->activeQuestion + 1;
            echo '<progress class="bar" max="3" value="' . $current . '">';
        }

        function placeAlternatives()
        {
            echo '<div class="alternatives">';

            $alternatives = $this->questions[$this->activeQuestion]->getAlternatives();

            foreach($alternatives as $alternative)
            {
                echo '<input type="button" class="button alternative hover-highlight no-select-mark" onClick="checkAnswer(' . "'" . $alternative->text . "'," . $alternative->is_correct . ',this)"';

                echo "id='" . $alternative->is_correct . "'";

                echo 'value="' . $alternative->text . '">';
            }

            echo '</div>';
        }

        function createResultPage()
        {
            echo "<div class='result'><h1> Resultat </h1>";

            echo "<div class='questions'>";

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

            echo "</div></div>";
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

        function getQuestions()
        {
            return $this->questions;
        }

        function addAnswer($text, $is_correct)
        {
            $this->questions[$this->activeQuestion]->addAnswer(new Alternative($text, $is_correct));
        }
    }

?>