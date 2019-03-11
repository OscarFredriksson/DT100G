<?php


    function add_entry($name, $message)
    {
        if(strlen($name) == 0)
        {
            echo '<script> alert("Du måste fylla i ett namn"); </script>';
        }
        else if(strlen($message) == 0)
        {
            echo '<script> alert("Du kan inte lämna ett tomt meddelande"); </script>';
        }
        else
        {
            $data = array($name, $message, date("Y-m-d H:i:s"));

            $serializedData = serialize($data);

            $path = "/Applications/XAMPP/xamppfiles/htdocs/Labbar/Labb4/require/data.txt";

            $file = fopen($path, 'a');
            fwrite($file, $serializedData);
            fclose($file);
        }
    }

    function fill_list()
    {
        $path = "/Applications/XAMPP/xamppfiles/htdocs/Labbar/Labb4/require/data.txt";

        $file = fopen($path, 'r');
        while (!feof($file)) 
        {
            $data = unserialize(fgets($file));
            create_flat_box($data[0], $data[2], $data[1]);
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