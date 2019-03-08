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
            //Do the thing
        }
    }

?>