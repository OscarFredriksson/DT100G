<!DOCTYPE html>
<html lang="sv"> 

    <?php
        require "require/process.php";
    ?>

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        
        <title> Labb4 </title>
    </head>

    <body>
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

        <?php
            if(!empty($_POST))
            {
                add_entry($_POST["name"], $_POST["message"]);
            }
        
            include "includes/footer.php"
        ?>

       

    </body>

</html>