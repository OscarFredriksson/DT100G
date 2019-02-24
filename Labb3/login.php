<!DOCTYPE html>
<html lang="sv">
    <?php 
        session_start();

        include("includes/head.php"); 
    ?>



    <body class="login">

        <div class="login-box">
            <div class="items">
                <div class="row">
                    <i class="material-icons icon">account_circle</i>
                    <input class="box" type="text" placeholder="Användarnamn"/>
                </div>

                <div class="row">
                    <i class="material-icons icon">vpn_key</i>
                    <input class="box" type="password" placeholder="Lösenord"/>
                </div>
                
                <input class="button" type="submit" value="LOGGA IN"/>
            </div>        
        </div>

    </body>
</html>