<?php


    function add_entry($name, $message)
    {
        if(strlen($name) == 0)
        {
            echo '<script> alert("Du måste fylla i ett namn"); </script>';
            return false;
        }
        else if(strlen($message) == 0)
        {
            echo '<script> alert("Du kan inte lämna ett tomt meddelande"); </script>';
            return false;
        }
        else
        {
            $data = array($name, $message, date("Y-m-d H:i:s"));

            $serializedData = serialize($data) . PHP_EOL;

            $path = "/Applications/XAMPP/xamppfiles/htdocs/Labbar/Labb4/require/data.txt";

            $file = fopen($path, 'a');
            fwrite($file, $serializedData);
            fclose($file);
            return true;
        }
    }

    function fill_list()
    {
        $path = "/Applications/XAMPP/xamppfiles/htdocs/Labbar/Labb4/require/data.txt";

        $file = fopen($path, 'r');
        while (!feof($file)) 
        {
            $data = fgets($file);
            if(strlen($data) > 0)   
            {
                $data = unserialize($data);
                create_flat_box($data[0], $data[2], $data[1]);
            }
        }
        fclose($file);
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
        echo "</li>";
    }

?>