<!DOCTYPE html>
<html lang="sv">
    <?php 
        $username = "oscar";
        $password = "7892457348";

        include("includes/head.php"); 

        logout();
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
                if($_POST["username"] === $username && $_POST["password"] === $password)
                {
                    $_SESSION["loggedin"] = true;
                    header("Location: index.php");
                }
                else if (empty($_POST["username"]) || empty($_POST["password"])) 
                {
                    echo "Tomma fält";
                }            
                else
                {
                    echo "Fel användarnamn eller lösenord";
                }
            }
        ?>
    

    </body>
</html>
