<?php
    class File
    {
        private $file;
        private $path;

        public function __construct($path)
        {
            $this->path = $path;
        }
        

        public function add($name, $message)
        {
            $data = array($name, $message, date("Y-m-d H:i:s"));

            $serializedData = serialize($data) . PHP_EOL;

            $this->file = fopen($this->path, 'a');
            fwrite($this->file, $serializedData);
            fclose($this->file);
        }

        public function get_all()
        {
            $returnArray = Array();
            $this->file = fopen($this->path, 'r');
            while (!feof($this->file)) 
            {
                $data = fgets($this->file);
                if(strlen($data) > 0)   
                {
                    $data = unserialize($data);
                    array_push($returnArray, $data);
                }
            }
            return $returnArray;
            fclose($this->file);
        }
    }

    function create_flat_box($name, $date, $message)
    {   
        echo "<li class='flat-box'>";
        echo "<div class='upper-text'>";
        echo "<p>".$name."</p>";
        echo "<p>".$date."</p>";
        echo "</div>";
        echo "<hr>";
        echo "<p class='lower-text'>".$message."</p>";
        echo "<hr>";
        echo "<input class='button' type='button' value='Radera'>";
        echo "</li>";
    }

?>