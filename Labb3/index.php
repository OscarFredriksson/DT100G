<!DOCTYPE html>
<html lang="sv">
    <?php include("includes/head.php"); ?>       

    <body>
        <div class="wrapper">
            <?php $currentPage = 'index' ?>
            <?php include("includes/header.php"); ?>

            <ul class="box-list">
                <li class="flat-box">
                    <p class="upper-text"> Har du tidigare erfarenhet av utveckling med PHP? </p>
                    <hr>
                    <p class="lower-text"> Nej </p>
                </li>
                
                <li class="flat-box"> 
                    <p class="upper-text"> Hur har du valt att strukturera upp dina filer och kataloger? </p>
                    <hr>
                    <p class="lower-text"> Jag har lagt alla php filer som includeras inom andra filer i en egen mapp, resten ligger i grundkatalogen. </p> 
                </li> 
                
                
                <li class="flat-box"> 
                    <p class="upper-text"> Har du följt guiden, eller skapat på egen hand? </p>
                    <hr>
                    <p class="lower-text"> Tog inspiration från guiden för include-mappen, men skippade css mappen då den inte kändes nödvändig när jag endast har en css-fil. </p>
                </li>
                
                <li class="flat-box"> 
                    <p class="upper-text"> Har du gjort några förbättringar eller vidareutvecklingar av guiden (om du följt denna)?</p>
                    <hr>
                    <p class="lower-text"> ..... </p> 
                </li>
                
                <li class="flat-box"> 
                    <p class="upper-text"> Vilken utvecklingsmiljö har du använt för uppgiften (Editor, webbserver etcetera)? </p>
                    <hr>
                    <p class="lower-text"> Visual Studio Code + XAMPP </p>
                </li>
                
                <li class="flat-box"> 
                    <p class="upper-text"> Har något varit svårt med denna uppgift? </p>
                    <hr>
                    <p class="lower-text"> Php var klurigt i början, men när man började förstå syftet med det så flöt det mesta på. </p> 
                </li>
            </ul>

            <?php include("includes/footer.php") ?>
        </div>
    </body>

</html>