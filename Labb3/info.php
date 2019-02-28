<!DOCTYPE html>
<html lang="sv">
    
    <?php 
        require("requires/session.php");
        check_session();

        $currentPage = 'info';
        
        include("includes/head.php"); 
    ?>

    <body>
        <div class="wrapper">
            <?php include("includes/header.php"); ?>

            <ul class="box-list">
                <li class="flat-box">
                    <p class="upper-text"> Datum/Klockslag </p>
                    <hr>
                    <p class="lower-text"> <?php echo date("Y-m-d H:i:s") ?> </p> 
                </li> 
                
                <li class="flat-box"> 
                    <p class="upper-text"> IP-adress </p>
                    <hr>
                    <p class="lower-text"> <?php echo $_SERVER['REMOTE_ADDR'] ?> </p> 
                </li>
                
                <li class="flat-box"> 
                    <p class="upper-text"> Sökväg/Filnamn </p>
                    <hr>
                    <p class="lower-text"> <?php echo getcwd() ?> </p>
                </li>
                
                <li class="flat-box"> 
                    <p class="upper-text"> User agent-sträng </p>
                    <hr>
                    <p class="lower-text"> <?php echo $_SERVER['HTTP_USER_AGENT'] ?> </p> 
                </li>
            </ul>   

            <?php include("includes/footer.php") ?>
        </div>
    </body>
</html>