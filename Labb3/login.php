<!DOCTYPE html>
<html lang="sv">
    <?php 
        require 'requires/session.php';    
        new_session();  //Starta en ny session, om det redan fanns en inloggad session så loggas den ut, alltså räcker det att gå till login.php för att logga ut

        include 'includes/head.php';   //Inkludera projektets <head>
    ?>

    <body class="login">

        <form method="post">    <!-- Skapa en form för inmatningen -->

            <ul>
                <li class="input-row">  <!-- En rad bestående av ikon + input-fält -->
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
            if(!empty($_POST))  //Om formen har skickats iväg, alltså om användaren har tryckt på "logga in"
            {
                check_login($_POST["username"], $_POST["password"]);    //Kolla om användarnamnet och lösenordet är rätt
            }
        ?>

    </body>
</html>
