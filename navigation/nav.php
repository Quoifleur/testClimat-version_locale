<nav>
  <div class="menu">
    <div class="SousMenuG"><a href="index.php">Accueil</a></div>
    <?php
    if (isset($_COOKIE['logged'])) {
      echo '<div class="SousMenu"><a href="userThingsTer.php">Compte</a></div>';
    } else {
      echo '<div class="SousMenu"><a href=""></a></div>';
    }
    ?>
    <div class="SousMenu"><a href=""></a></div>
    <!-- <div class="SousMenu"><a href="testlectureCSV.php">CSV</a></div>
    <div class="SousMenu"><a href="testlectureCSV copy.php">CSV</a></div>
    <div class="SousMenu"><a href="testClimatResultatBis.php">CSVRésultat</a></div>
    <div class="SousMenu"><a href="TestClimatAPropos.php">A propos</a></div>
    <div class="SousMenu"><a href="TestClimatContact.php">Contact</a></div> -->
    <div class="SousMenuD"><a href="testClimatAide.php">Aide</a></div>
  </div>
</nav>