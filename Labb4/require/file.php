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
            $allData = Array();
            $this->file = fopen($this->path, 'r');
            
            $rowNumber = 1;
            while (!feof($this->file)) 
            {
                $row = fgets($this->file);
                if(strlen($row) > 0)   
                {
                    $row = unserialize($row);
                    
                    array_unshift($row, (string)$rowNumber);

                    array_push($allData, $row);
                }
                $rowNumber++;
            }
            fclose($this->file);

            return $allData;
        }

        public function delete($id)
        {            
            $data = file($this->path);  //Hämta filens innehåll till en array

            unset($data[$id - 1]);  //Ta bort 

            
            $this->file = fopen($this->path, 'w+');
            
            foreach($data as $line) //Skriv tillbaks
            { 
                fwrite($this->file, $line); 
            }

            fclose($this->file);

            header("Location: index.php?part=1");
        }
    }
?>