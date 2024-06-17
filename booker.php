<!-- STARTING PHP SECTION -->

<?php
session_start();

include_once('includes/connection.php');

  /* If logged in, display page*/
if (isset($_SESSION['logged_in_booker'])) {

  date_default_timezone_set('Europe/Helsinki');

  /* Get 50 most recent links*/
  $query = $pdo->prepare("SELECT * FROM links ORDER BY thedate DESC");
  $query->execute();

  $links = $query->fetchAll();

  /* Get all tags */
  $query = $pdo->prepare("SELECT * FROM tags");
  $query->execute();

  $tags = $query->fetchAll();

  /* If the New Tag form is set, create a new tag */
  if (isset($_POST['createtag'])){
    $newtagname = $_POST['createtag'];
    if (empty($newtagname)) {
          $error = 'Please put a category for the link!';
        /* Reload page */
        header('Location: booker.php');
        }
    /* If tag description is set, set it , otherwise the description is No Description! */
    if (!empty($_POST['createtaginfo'])){
      $newtagnameinfo = $_POST['createtaginfo'];
    } else {
      $newtagnameinfo = 'No Description!';
            }

    $query = $pdo->prepare("INSERT INTO tags (tagName, tagCreated, tagInfo) VALUES (?, ?, ?)");
    $query->bindvalue(1, $newtagname);
    $query->bindvalue(2, time());
    $query->bindvalue(3, $newtagnameinfo);
    $query->execute();

    /* Reload page */
      header('Location: booker.php');

  /* If the New Tag form is NOT set, process the link submission form */
    } else {

      /* if missing tag is set, set the tag for the link! */
      if (isset($_POST['missingbox'])) {
          $missingtag = $_POST['missingtags'];
          $missinglinkid = $_POST['missinglinkid'];

          $error = "THIS IS SET";

          ?>
          <p><?php echo $missingtag; ?></p>
          <p><?php echo $missinglinkid; ?></p>
          <?php

          $query = $pdo->prepare("INSERT INTO linktags (linkid, tagid, timecreated) VALUES (?, ?, ?)");
          $query->bindvalue(1, $missinglinkid);
          $query->bindvalue(2, $missingtag);
          $query->bindvalue(3, time());
          $query->execute();

          /* Reload page */
          header('Location: booker.php');
        }

  /* If bookmark is submitted, start processing form content */
$share = filter_input(INPUT_POST, 'share', FILTER_SANITIZE_STRING);
$sharelink = Null;
 if ($share) {$sharelink = 1;}

  if (isset($_POST['name'], $_POST['bookmarklink'])){
    $name = $_POST['name'];
    $bookmarklink = $_POST['bookmarklink'];
    $linktag = $_POST['tags'];

    /* If either field in the form is empty, send error */
    if (empty($name) || empty($bookmarklink)) {
      $error = 'PUT A FUCKING LINK';
    }
     /* If fields have content, send it to the links table */
      else {
      $query = $pdo->prepare("INSERT INTO links (name, link, thedate, private) VALUES (?, ?, ?, ?)");
      $query->bindvalue(1, $name);
      $query->bindvalue(2, $bookmarklink);
      $query->bindvalue(3, time());
      $query->bindvalue(4, $sharelink);
      $query->execute();

      /* Get linkid of posted link from database*/

      $query = $pdo->prepare("SELECT * FROM links ORDER BY linkid DESC LIMIT 1");
      $query->execute();
      $postedlinkid = $query->fetch();

      /* Add tag for post to linktags table*/

      $query = $pdo->prepare("INSERT INTO linktags (linkid, tagid, timecreated) VALUES (?, ?, ?)");
      $query->bindvalue(1, $postedlinkid['linkid']);
      $query->bindvalue(2, $linktag);
      $query->bindvalue(3, time());
      $query->execute();

      /* Reload page */
        header('Location: booker.php');

      }
    }
  }


?>


<!-- HTML SECTION -->

<html>
  <head>
    <title>BOOKER MACKENZIE</title>
    <!-- Style sheet -->
    <link rel="stylesheet" href="style.css">

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

<!-- Error goes here if there is one -->
  <?php if (isset($error)) { ?>
      <p style="color:#ff0000; font-size:20pt;"><?php echo $error; ?></p>
  <?php  } ?>

  <hr class="rounded">

  <!-- Bookmark Submission form -->
  <h1>Post a Link</h1>
 <div class="form">
 <form action="booker.php" method="post" autocomplete="off">
   <input type="text" name="name" placeholder="Name"/>
   <br>
   <input type="text" name="bookmarklink" placeholder="Bookmark Link"/>
   <br>
   <select name="tags" id="tags" class="custom-select">
     <?php foreach($tags as $tagsdata) { ?>
        <option value="<?php echo $tagsdata['tagid'];?>"><?php echo $tagsdata['tagName'];?></option>
    <?php } ?>
   </select>
   <br>
   <br>
   <input type="submit" value="Add Bookmark" />
 </form>
 </div>

 <hr class="rounded">

 <!-- End of Bookmark Submission form -->

 <!-- Create a new category  -->
 <h1>Create a New Category</h1>
 <form action="booker.php" method="post" autocomplete="off">
   <input type="text" name="createtag" placeholder="Name of Tag"/>
   <br>
   <input type="text" name="createtaginfo" placeholder="Description"/>
   <br>
   <input type="submit" value="Create new Tag" />
 </form>

 <hr class="rounded">

 <!-- End of Create a new category  -->

<!-- Display links -->
<h1>Most Recent Links</h1>
<p><a href="tags.php" style="color: red;">Browse by Category</a></p>
<div class="center">
  <hr class="rounded">
  <?php
  foreach ($links as $linkdata) {
    ?>

    <!-- Display link -->
    <p>
    <a href="<?php echo $linkdata['link']; ?>" target="_blank">
      <?php echo $linkdata['name']; ?>
    </p>
    </a>

    <!-- Display time link was saved -->
    <p style="margin-top: -15px; color: grey;">
    <?php echo date("d-m-Y H:i", $linkdata['thedate']);?>
    </p>

    <hr class="rounded">

    <?php
    /* If the post has no tags! */
    $query = $pdo->prepare("SELECT * FROM linktags WHERE linkid=?");
    $query->bindvalue(1, $linkdata['linkid']);
    $query->execute();

    $doesithavetags = $query->fetchAll();

    if(empty($doesithavetags)){ ?>

      <form action="booker.php" method="post" autocomplete="off" id="<?php echo $linkdata['linkid']?>" >
      <br>
      <select name="missingtags" id="missingtags">
        <option disabled selected value> -- select a tag -- </option>
        <?php foreach($tags as $tagsdata) { ?>
           <option value="<?php echo $tagsdata['tagid'];?>"><?php echo $tagsdata['tagName'];?></option>
       <?php } ?>
      </select>
       <input type="checkbox" id="missingbox" name="missingbox" value="missingbox">
       <input type="hidden" id="missinglinkid" name="missinglinkid" value="<?php echo $linkdata['linkid']?>">
       <input type="submit" value="Add Missing Tag!" />
    </form>
    <?php
        }
    ?>


<?php } ?>
  <hr class="rounded">
</div>

<!-- End of Display lastest 50 links -->


</html>


<!-- If not logged in, go back to index page -->
<?php
} else {
  header('Location: index.php');
}

 ?>
