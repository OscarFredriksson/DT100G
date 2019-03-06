<!DOCTYPE html>
<html lang="sv">
    
    <?php 
        require 'requires/session.php';
        check_session();    //Kolla om användaren är inloggad, är användaren inloggad kollas timeout-tiden, efter 15 inaktiva minuter loggas användaren automatiskt ut

        $currentPage = 'info';
        
        include 'includes/head.php';   //Inkludera projektets <head>
    ?>

    <body>
        <?php 
            include 'includes/header.php'; //Inkludera projektets <header> med titel och navigeringsknappar
        ?>    

        <ul class="box-list">   <!-- Lista för info-boxarna -->
            <li class="flat-box">   <!-- En info-box med en övre och en undre text -->
                <p class="upper-text"> Datum/Klockslag </p>
                <hr>    <!-- En delningslinje -->
                <p class="lower-text"> <?php echo date("Y-m-d H:i:s") ?> </p> <!-- Skriv ut dagens datum + klockslag -->
            </li> 
            
            <li class="flat-box"> 
                <p class="upper-text"> IP-adress </p>
                <hr>
                <p class="lower-text"> <?php echo $_SERVER['REMOTE_ADDR'] ?> </p> <!-- Skriv ut ip-adress -->
            </li>
            
            <li class="flat-box"> 
                <p class="upper-text"> Sökväg/Filnamn </p>
                <hr>
                <p class="lower-text"> <?php echo getcwd() ?> </p> <!-- Skriv ut projektets filväg -->
            </li>
            
            <li class="flat-box"> 
                <p class="upper-text"> User agent-sträng </p>
                <hr>
                <p class="lower-text"> <?php echo $_SERVER['HTTP_USER_AGENT'] ?> </p> <!-- Skriv ut user agent-sträng -->
            </li>
        </ul>   

        <?php 
            include 'includes/footer.php'; //Inkludera projektets <footer>
        ?>
    </body>
</html>