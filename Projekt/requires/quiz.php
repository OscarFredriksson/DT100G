<?php
    require "database/database.php";

    class Quiz
    {
        private $id;
        private $questions = Array();
        private $activeQuestion;

        function __construct($id)
        {


            $this->id = $id;
            
            $database = new Database();

            $result = $database->get_all_questions($this->id);
            
            foreach($result as $question)
            {                
                $this->questions[] = $question;
            }
            $this->activeQuestion = 0;
        }

        function placeQuestion()
        {
            echo '<div class="question"><h1>'; 
            
            echo $this->questions[$this->activeQuestion]->getQuestion();
            
            echo '</h1></div>';

            $this->placeAlternatives();
        }

        function placeAlternatives()
        {
            echo '<div class="alternatives">';

            $answers = $this->questions[$this->activeQuestion]->getAnswers();

            foreach($answers as $answer)
            {
                echo '<input type="button" class="alternative hover-highlight" onClick="checkAnswer(this)"';

                if($answer->is_correct) echo 'id="correct"';
                else                    echo 'id="false"';

                echo 'value="' . $answer->text . '">';
            }

            echo '</div>';
        }

        function nextQuestion()
        {
            $this->activeQuestion++;
            return $this->activeQuestion;
        }

        function setQuestion($nr)
        {
            $this->activeQuestion = $nr;
        }

        function getCurrent()
        {
            return $this->activeQuestion;
        }
    }

?>