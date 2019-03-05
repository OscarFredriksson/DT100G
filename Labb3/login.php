<!DOCTYPE html>
<html lang="sv">
    <?php 
        require("requires/session.php");
        new_session();

        include("includes/head.php"); 
    ?>

    <body class="login">

        <form method="post">

            <ul>
                <li class="input-row">
                    <i class="material-icons icon">account_circle</i>
                    <input class="field" type="text" name="username" placeholder="Användarnamn"/>
                </li>

                <li class="input-row">
                    <i class="material-icons icon">vpn_key</i>
                    <input class="field" type="password" name="password" placeholder="Lösenord"/>
                </li>
                
                <li>
                    <input class="button" type="submit" name="btn" value="LOGGA IN"/> 
                </li>
            </ul>

        </form>

        <?php 
            if(!empty($_POST))
            {
                check_login($_POST["username"], $_POST["password"]);
            }
        ?>

    </body>
</html>
