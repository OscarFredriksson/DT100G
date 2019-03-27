<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Projekt/requires/question.php";

    class Database
    {
        private $conn;

        public function __construct()
        {
            $this->connect();
        }

        public function connect()
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
            $query = "SELECT QUIZ_ID FROM QUIZZES";
                
            $result = $this->conn->query($query);

            $allData = Array();

            while($row = $result->fetch_assoc())
            {
                $allData[] = $row["QUIZ_ID"];
            }
            return $allData;
        }

        public function get_quiz_title($quiz_ID)
        {
            $query = "SELECT TITLE FROM QUIZZES WHERE QUIZ_ID=" . $quiz_ID . " LIMIT 1";

            $result = $this->conn->query($query);

            return $result->fetch_assoc()["TITLE"];
        }

        public function get_quiz_descr($quiz_ID)
        {
            $query = "SELECT DESCRIPTION FROM QUIZZES WHERE QUIZ_ID=" . $quiz_ID . " LIMIT 1";

            $result = $this->conn->query($query);

            return $result->fetch_assoc()["DESCRIPTION"];
        }

        public function get_all_questions($quiz_ID)
        {
            $query = "SELECT * FROM QUESTIONS WHERE QUIZ_ID=" . $quiz_ID;

            $result = $this->conn->query($query);

            $questions = Array();

            while($row = $result->fetch_assoc())
            {
                $question = new Question($row["TEXT"]);

                $alternatives = $this->get_all_alternatives($row["QUESTION_ID"]);

                foreach($alternatives as $alternative)
                {
                    $question->addAlternative($alternative);
                }
                
                $questions[] = $question;
            }
            return $questions;
        }

        public function get_question($question_ID)
        {
            $query = "SELECT * FROM QUESTIONS WHERE QUESTION_ID=" . $question_ID;

            $result = $this->conn->query($query);

            return $result->fetch_assoc()["TEXT"];
        }

        public function get_all_alternatives($question_ID)
        {
            $query = "SELECT * FROM ALTERNATIVES WHERE QUESTION_ID=" . $question_ID;

            $result = $this->conn->query($query);

            $alternatives = Array();

            while($row = $result->fetch_assoc())
            {
                $alternatives[] = new Alternative($row["TEXT"], $row["IS_CORRECT"]);
            }
            return $alternatives;
        }

        public function get_alternative_text($alternative_ID)
        {
            $query = "SELECT TEXT FROM ALTERNATIVES WHERE ALTERNATIVE_ID=" . $alternative_ID . " LIMIT 1";

            $result = $this->conn->query($query);

            return $result->fetch_assoc()["TEXT"];
        }

        public function check_answer($alternative_ID)
        {
            $this->add_answer($alternative_ID);

            $query = "SELECT IS_CORRECT FROM ALTERNATIVES WHERE ALTERNATIVE_ID=" . $alternative_ID . " LIMIT 1";

            $result = $this->conn->query($query);

            return $result->fetch_assoc()["IS_CORRECT"];
        }

        public function add_answer($alternative_ID)
        {
            $query = "INSERT INTO ANSWERS (ALTERNATIVE_ID) VALUES (" . $alternative_ID . ")";
            
            if (!$this->conn->query($query)) 
            {
                die("Error:" . $this->conn->error);
            } 
        }

        public function clear_table($table)
        {
            $query = "TRUNCATE TABLE " . $table;
            
            if (!$this->conn->query($query)) 
            {
                die("Error:" . $this->conn->error);
            } 
        }

        public function get_correct_answer($question_ID)
        {
            $query = "SELECT QUESTION_ID FROM QUESTIONS WHERE QUESTION_ID=" . $question_ID . "AND IS_CORRECT=1 LIMIT 1";

            $result = $this->conn->query($query);

            return $result->fetch_assoc()["QUESTION_ID"];
        }
    }

?>