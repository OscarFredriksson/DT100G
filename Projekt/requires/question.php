<?php
    class Question
    {
        public $text;
        private $alternatives = Array();
        
        private $answer;

        function __construct($text)
        {
            $this->text = $text;
        }

        function addAlternative($alternative)
        {
            $this->alternatives[] = $alternative;
        }

        function getQuestion()
        {
            return $this->text;
        }

        function getAlternatives()
        {
            shuffle($this->alternatives);
            return $this->alternatives;
        }

        function addAnswer($answer)
        {
            $this->answer = $answer;
        }

        function getAnswer()
        {
            return $this->answer;
        }

        function getCorrectAnswer()
        {
            foreach($this->alternatives as $alternative)
            {
                if($alternative->is_correct)    return $alternative;
            }

            die("Error: Korrupt Quiz - Hittade inget rätt svar.");
        }
    }

    class Alternative
    {
        public $text;
        public $is_correct;

        function __construct($text, $is_correct)
        {
            $this->text = $text;
            $this->is_correct = $is_correct;
        }
    }

?>