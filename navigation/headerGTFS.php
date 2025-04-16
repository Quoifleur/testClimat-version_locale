<header>

    <a href="horsThemeGTFS.php" id="header"><img src="icones/svg/tGTFS_logo.svg" alt="testGTFS" id="tGTFS_logo" /></a>
    <?php
    if (isset($_COOKIE['logged'])) {
        echo '<img class"logged_picture" src="icones/svg/tGTFS_favicon.svg"/> ';
    }
    ?>
</header>