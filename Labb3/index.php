<!DOCTYPE html>
<html lang="sv"> 
    <?php 
        require 'requires/session.php';
        check_session();    //Kolla om användaren är inloggad, är användaren inloggad kollas timeout-tiden, efter 15 inaktiva minuter loggas användaren automatiskt ut

        $currentPage = 'index';

        include 'includes/head.php';   //Inkludera projektets <head>
    ?>

    <body>
        <?php 
            include 'includes/header.php';     //Inkludera projektets <header> med titel och navigeringsknappar
        ?>    

        <ul class="box-list">   <!-- Lista för info-boxarna -->
            <li class="flat-box">   <!-- En info-box med en övre och en undre text -->
                <p class="upper-text"> Har du tidigare erfarenhet av utveckling med PHP? </p>
                <hr>    <!-- En delningslinje -->
                <p class="lower-text"> Nej </p>
            </li>
            
            <li class="flat-box"> 
                <p class="upper-text"> Hur har du valt att strukturera upp dina filer och kataloger? </p>
                <hr>
                <p class="lower-text"> Jag har gjort en mapp för include-filer, en för require-filer, samt en för css filer. </p> 
            </li>  
            
            <li class="flat-box"> 
                <p class="upper-text"> Har du följt guiden, eller skapat på egen hand? </p>
                <hr>
                <p class="lower-text"> Delvis, ja. </p>
            </li>
            
            <li class="flat-box"> 
                <p class="upper-text"> Har du gjort några förbättringar eller vidareutvecklingar av guiden (om du följt denna)?</p>
                <hr>
                <p class="lower-text"> La till en mapp för require-filer och skippade javascript-mappen då jag inte har någon separat javascript fil. </p> 
            </li>
            
            <li class="flat-box"> 
                <p class="upper-text"> Vilken utvecklingsmiljö har du använt för uppgiften (Editor, webbserver etcetera)? </p>
                <hr>
                <p class="lower-text"> Visual Studio Code har använts för all textredigering och XAMPP för Apache server. </p>
            </li>
            
            <li class="flat-box"> 
                <p class="upper-text"> Har något varit svårt med denna uppgift? </p>
                <hr>
                <p class="lower-text"> Php var klurigt i början, men när man började förstå det så flöt det mesta på. </p> 
            </li>
        </ul>

        <?php 
            include 'includes/footer.php'; //Inkludera projektets <footer> 
        ?>
     </body>

</html>