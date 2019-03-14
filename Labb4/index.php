<?php  
    require "require/file.php";
    require "require/database.php";
    require "require/website.php";

    $website = new Website();

    if(empty($_GET["part"]))
    {
        header("Location: index.php?part=1");
    }
    else
    {
        $website->setPart($_GET["part"]);
    }

    if($website->getPart() == 1)
    {
        $path = "data.txt";
                    
        $website->setDataLocation(new File($path));
    }
    else if ($website->getPart() == 2)
    {
        $website->setDataLocation(new Database());
    }
    else
    {
        die("Error: no part set.");
    }

    if(!empty($_GET["delete"]))
    {
        $website->deleteEntry(($_GET["delete"]));
    }
?>

<!DOCTYPE html>
<html lang="sv"> 
    <?php 
        $website->createHead();
    ?>    

    <body>
        <?php
            $website->createHeader();
        ?>

        <div class="content">
            
            <?php
                $website->createLeftColumn();
                $website->createRightColumn();
            ?>

        </div>

        <?php
            $website->createFooter();
            $website->importScripts();
        ?>

    </body>
</html>

<?php
    if(!empty($_POST))
    {   
        $website->addEntry($_POST["name"], $_POST["message"]);
    }
?>