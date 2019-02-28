<!DOCTYPE html>
<html lang="sv">
    <?php 
        

        require("requires/session.php");
        session_start();
        logout();

        include("includes/head.php"); 
    ?>

    <body class="login">

        <form method="post">

            <div class="login-box">
                <div class="items">
                    <div class="row">
                        <i class="material-icons icon">account_circle</i>
                        <input class="box" type="text" name="username" placeholder="Användarnamn"/>
                    </div>

                    <div class="row">
                        <i class="material-icons icon">vpn_key</i>
                        <input class="box" type="password" name="password" placeholder="Lösenord"/>
                    </div>
                    
                    <input class="button" type="submit" name="btn" value="LOGGA IN"/>
                </div>        
            </div>
        </form>


        <?php 
            if(!empty($_POST))
            {
                check_login($_POST["username"], $_POST["password"]);
            }
        ?>
    

    </body>
</html>
