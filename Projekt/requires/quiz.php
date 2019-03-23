<?php
    require "website.php";
    require "database.php";

    class Quiz extends Website
    {
        private $id;
        private $questions = Array();

        function __construct($id)
        {
            $this->id = $id;
            
            $database = new Database();

            $result = $database->get_all_questions($this->id);
            
            foreach($result as $question)
            {                
                $this->questions[] = $question;
            }
        }

        function placeQuestion()
        {
            echo '<div class="question"><h1>'; 
            echo $this->questions[0]->getQuestion();
            echo '</h1></div>';
        }

        function placeAlternatives()
        {
            echo '<div class="alternatives">';

            $answers = $this->questions[0]->getAnswers();

            foreach($answers as $answer)
            {
                echo '<input type="button" class="alternative" onClick="checkAnswer(this)"';

                if($answer->is_correct) echo 'id="correct"';
                else                    echo 'id="false"';

                echo 'value="' . $answer->text . '">';
            }

            echo '</div>';
        }
    }

?>