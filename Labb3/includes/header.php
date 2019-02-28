<header>
    <p class="header-title"> LABORATION 3 </p>
    <ul class="nav">
        <li <?php if ($currentPage === 'index') echo 'class="active"'; ?>><a href="index.php">HEM</a></li>
        <li <?php if ($currentPage === 'info')  echo 'class="active"'; ?>><a href="info.php">INFO</a></li>
        <li class="logout"> <a href="login.php">LOGGA UT</a></li> 
    </ul>

</header>