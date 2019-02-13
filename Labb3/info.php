<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style.css"> <!--Importera stil-mallen-->
        
        <title> Labb3 </title>
    </head>

    <body>

        <?php include("mainmenu.php"); ?>

        <h2> Information </h2>

        <ul>
            <li> Datum/Klockslag: <span> <?php echo date("Y-m-d H:i:s") ?> </li> 
            
            <li> Din IP-adress: <span> <?php echo $_SERVER['REMOTE_ADDR'] ?> </li>
            
            <li> Sökväg/Filnamn: <span> <?php echo getcwd() ?> </li>
            
            <li> User agent-sträng: <span> <?php echo $_SERVER['HTTP_USER_AGENT'] ?> </li>
        </ul>   

    </body>
</html>