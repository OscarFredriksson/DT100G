<?php
    class Question
    {
        private $question;
        private $answers = Array();

        function __construct($question)
        {
            $this->question = $question;
        }

        function addAnswer($answer)
        {
            $this->answers[] = $answer;
        }

        function getQuestion()
        {
            return $this->question;
        }

        function getAnswers()
        {
            return $this->answers;
        }

    }

    class Answer
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