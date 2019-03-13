<!DOCTYPE html>
<html lang="sv"> 

    <?php
        require "require/process.php";

        $path = $_SERVER['DOCUMENT_ROOT'].'/Labb4/require/'. 'data.txt';
                        
        $file = new File($path);
    ?>

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        
        <title> Labb4 </title>
    </head>

    <body>
        <?php
            include "includes/header.php";
        ?>

        <div class="content">
            
            <div class="left-column">
                <form method="post">
                    <ul class="entry" >
                        <li>
                            <input type="text" name="name" placeholder="Namn">
                        </li>

                        <li class="message">
                            <textarea type="text" name="message" placeholder="Meddelande"></textarea>
                        </li>
                        
                        <li class="button">
                            <input type="submit" name="Skicka">
                        </li>
                </form>
            </div>
            
            <div class="right-column">
                <ul class="box-list">   <!-- Lista för info-boxarna -->
                    <?php 
                        $data = $file->get_all();
                        
                        foreach($data as $entry)
                        {
                            create_flat_box($entry[0], $entry[2], $entry[1]);
                        }
                    ?>
                </ul>
            </div>
        
        </div>

        <?php
            if(!empty($_POST))
            {
                if(empty($_POST["name"]))
                {
                    echo '<script> alert("Du måste fylla i ett namn"); </script>';
                }
                else if(empty($_POST["message"]))
                {
                    echo '<script> alert("Du kan inte lämna ett tomt meddelande"); </script>';
                }
                else
                {
                    $file->add($_POST["name"], $_POST["message"]);
                    
                    //Undvik resubmit av formen
                    header("location: {$_SERVER['PHP_SELF']}");
                    exit;
                }
                
                
            }
        
            include "includes/footer.php";
        ?>

       

    </body>

</html>