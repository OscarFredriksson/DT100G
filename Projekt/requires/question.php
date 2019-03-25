<?php
    class Question
    {
        private $id;
        private $text;
        private $alternatives = Array();

        function __construct($id, $text)
        {
            $this->id = $id;
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
            return $this->alternatives;
        }

    }

    class Alternative
    {
        public $id;
        public $text;
        public $is_correct;

        function __construct($id, $text, $is_correct)
        {
            $this->id = $id;
            $this->text = $text;
            $this->is_correct = $is_correct;
        }
    }

?>