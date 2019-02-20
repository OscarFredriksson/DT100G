<!DOCTYPE html>
<html lang="sv">
    <?php include("head.php"); ?>

    <body>

        <?php $currentPage = 'info' ?>
        <?php include("navigation.php"); ?>

        <div class="info">

            <h2> Information </h2>

            <ul>
                <li class="info-title"> Datum/Klockslag: <span class="info-text"> <?php echo date("Y-m-d H:i:s") ?> </span> </li> 
                
                <li class="info-title"> Din IP-adress: <span class="info-text"> <?php echo $_SERVER['REMOTE_ADDR'] ?> </span> </li>
                
                <li class="info-title"> Sökväg/Filnamn: <span class="info-text"> <?php echo getcwd() ?> </span> </li>
                
                <li class="info-title"> User agent-sträng: <span class="info-text"> <?php echo $_SERVER['HTTP_USER_AGENT'] ?> </span> </li>
            </ul>   

        </div>

    </body>
</html>