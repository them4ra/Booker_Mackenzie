<!-- STARTING PHP SECTION -->

<?php
session_start();

include_once('includes/connection.php');

  /* If logged in, display page*/
if (isset($_SESSION['logged_in_booker'])) {

  /* Get all tags */
  $query = $pdo->prepare("SELECT * FROM tags");
  $query->execute();

  $tags = $query->fetchAll();


?>

<html>
  <head>
    <title>BOOKER MACKENZIE</title>
    <!-- Style sheet -->
    <link rel="stylesheet" href="style.css"/>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="manifest" href="favicons/site.webmanifest">


  </head>

  <body>

<!-- Logo -->
  <div class="logo">
    <img src="booker.png" height="10%">
    <h1>BOOKER MACKENZIE</h1>
    <br>
  </div>
<!-- End of Logo-->

<div class="form">
<form action="tags.php" method="post" autocomplete="off">
  <label for="tags">:Tag:</label>
  <br>
  <select name="chosentag" id="chosentag">
    <?php foreach($tags as $tagsdata) { ?>
       <option value="<?php echo $tagsdata['tagid'];?>"><?php echo $tagsdata['tagName'];?></option>
   <?php } ?>
  </select>
  <br>
  <br>
  <input type="submit" value="Select Tag" />
</form>
</div>

<!-- Display all links under selected tag -->
<?php

  /* Get all linkid's with given tagid*/

  if(!empty($_POST['chosentag'])){

    $chosentag = $_POST['chosentag'];

  } else {
    $chosentag = 1;

          }

  $query = $pdo->prepare("SELECT * FROM tags WHERE tagid=?");
  $query->bindvalue(1, $chosentag);
  $query->execute();

  $currenttagname = $query->fetch();

  $query = $pdo->prepare("SELECT * FROM linktags WHERE tagid=?");
  $query->bindvalue(1, $chosentag);
  $query->execute();

  $taglinkids = $query->fetchAll();

  /* Create an array with only the linkid values in it */

  $id_array = array_column($taglinkids, 'linkid');

  /* Create a list of question marks long enough for the MySQL query*/

  $in  = str_repeat('?,', count($id_array) - 1) . '?';

  /* Retrieve the booksmarks with the linkids we just got*/
  $query = $pdo->prepare("SELECT * FROM links WHERE linkid IN ($in);");
  $query->execute($id_array);

  $linksbytag = $query->fetchAll();

  ?>
<!-- Display all links of given tag -->
<h1>Bookmarks with the Tag <i><?php echo $currenttagname['tagName']; ?></i></h1>
<p><a href="booker.php">Return to Main</a></p>
<div class="center">
  <hr class="rounded">
  <?php
  foreach ($linksbytag as $linkdata) {
    ?>
    <p>
    <a href="<?php echo $linkdata['link']; ?>" target="_blank">
      <?php echo $linkdata['name']; ?>
    </p>
    </a>
<?php } ?>
  <hr class="rounded">
</div>

<!-- End of Display all links of given tag -->

</html>

<!-- If not logged in, go back to index page -->
<?php
  } else {
    header('Location: index.php');
  }

   ?>
