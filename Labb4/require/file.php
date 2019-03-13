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
            
            $row = 1;
            while (!feof($this->file)) 
            {
                $data = fgets($this->file);
                if(strlen($data) > 0)   
                {
                    $data = unserialize($data);
                    
                    array_unshift($data, (string)$row);

                    array_push($returnArray, $data);
                }
                $row++;
            }
            return $returnArray;
            fclose($this->file);
        }

        public function delete($id)
        {            
            $data = file($this->path);  //Hämta filens innehåll till en array

            unset($data[$id - 1]);  //Ta bort 

            
            $this->file = fopen($this->path, 'w+');
            
            foreach($data as $line) 
            { 
                fwrite($this->file, $line); 
            }

            fclose($this->file);

            header("Location: index.php?part=1");
        }
    }
?>