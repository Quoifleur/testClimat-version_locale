<header>
    <a href="index.php" id="header">TestClimat</a>
    <?php
    if (isset($_COOKIE['logged'])) {
        echo '<img class"logged_picture" src="favicon.png"/> ';
    }
    ?>
</header>