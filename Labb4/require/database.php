<?php

    class Database
    {
        private $conn;

        public function __construct()
        {
            $this->conn = new mysqli('localhost', 'root', '', 'labb4', 3306);
            
            if ($this->conn->connect_error) 
            {
                die("Connection failed: " . $this->conn->connect_error);
            }
                
        }

        public function __destruct()
        {
            $this->conn->close();
        }

        public function add($name, $message)
        {
            $query = "INSERT INTO Entries (Username, Post, PostDate) VALUES('$name', '$message', NOW());";

            if (!$this->conn->query($query)) 
            {
                die("Error:" . $this->conn->error);
            } 

        }

        public function get_all()
        {
            $query = "SELECT * FROM ENTRIES";
                
            $result = $this->conn->query($query);

            $allData = Array();

            while($row = $result->fetch_assoc())
            {
                array_push($allData, Array($row["id"], $row["username"], $row["post"], $row["postdate"]));    
            }
            return $allData;
        }

        public function delete($id)
        {
            $query = "DELETE FROM Entries WHERE ID=" .$id;

            if(!$this->conn->query($query)) 
            {
                die("Error:" . $this->conn->error);
            } 

            header("Location: index.php?part=2");
        }


    }

?>