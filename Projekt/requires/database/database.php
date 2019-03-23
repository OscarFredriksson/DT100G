<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Projekt/requires/question.php";

    class Database
    {
        private $conn;

        public function __construct()
        {
            $this->conn = new mysqli('localhost', 'root', '', 'quiz', 3306);
            
            mysqli_set_charset($this->conn,"utf8"); //Fixa åäö
            
            if ($this->conn->connect_error) 
            {
                die("Connection failed: " . $this->conn->connect_error);
            }
                
        }

        public function __destruct()
        {
            $this->conn->close();
        }

        public function get_all_quizzes()
        {
            $query = "SELECT * FROM QUIZZES";
                
            $result = $this->conn->query($query);

            $allData = Array();

            while($row = $result->fetch_assoc())
            {
                array_push($allData, Array($row["QUIZ_ID"], $row["TITLE"], $row["DESCRIPTION"]));    
            }
            return $allData;
        }

        public function get_all_questions($quiz_ID)
        {
            $query = "SELECT * FROM QUESTIONS WHERE QUIZ_ID=" . $quiz_ID;

            $result = $this->conn->query($query);

            $questions = Array();

            while($row = $result->fetch_assoc())
            {
                $question = new Question($row["TEXT"]);

                $answers = $this->get_all_answers($row["QUESTION_ID"]);

                foreach($answers as $answer)
                {
                    $question->addAnswer($answer);
                }
                
                $questions[] = $question;
            }
            return $questions;
        }

        public function get_all_answers($question_ID)
        {
            $query = "SELECT * FROM ANSWERS WHERE QUESTION_ID=" . $question_ID;

            $result = $this->conn->query($query);

            $answers = Array();
            while($row = $result->fetch_assoc())
            {
                $answers[] = new Answer($row["TEXT"], $row["IS_CORRECT"]);    
            }
            return $answers;
        }
    }

?>