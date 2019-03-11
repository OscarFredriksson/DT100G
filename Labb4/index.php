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
                    <li class="flat-box">   <!-- En info-box med en övre och en undre text -->
                        <div class="upper-text">
                            <p> Namn här</p>
                            <p> 2019-03-10 </p>
                        </div>
                        <hr>    <!-- En delningslinje -->
                        <p class="lower-text"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    </li>

                    <?php
                        fill_list();
                    ?>
                </ul>
            </div>
        
        </div>

        <?php
            if(!empty($_POST))
            {
                add_entry($_POST["name"], $_POST["message"]);
            }
        
            include "includes/footer.php";
        ?>

       

    </body>

</html>