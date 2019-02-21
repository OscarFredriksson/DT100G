<!DOCTYPE html>
<html lang="sv">
    <?php include("includes/head.php"); ?>

    <body>

        <?php $currentPage = 'info' ?>
        <?php include("includes/header.php"); ?>

        <div class="info">
            <ul>
                <li class="info-title"> Datum/Klockslag: <span class="info-text"> <?php echo date("Y-m-d H:i:s") ?> </span> </li> 
                
                <li class="info-title"> Din IP-adress: <span class="info-text"> <?php echo $_SERVER['REMOTE_ADDR'] ?> </span> </li>
                
                <li class="info-title"> Sökväg/Filnamn: <span class="info-text"> <?php echo getcwd() ?> </span> </li>
                
                <li class="info-title"> User agent-sträng: <span class="info-text"> <?php echo $_SERVER['HTTP_USER_AGENT'] ?> </span> </li>
            </ul>   
        </div>

        <?php include("includes/footer.php") ?>

    </body>
</html>