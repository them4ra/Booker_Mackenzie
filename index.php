<?php
session_start();

include_once('includes/connection.php');

if (isset($_SESSION['logged_in_booker'])){

  header('Location: booker.php');

 ?>
<?php
} else {
  if (isset($_POST['user'], $_POST['pass'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if (empty($user) or empty($pass)) {
      $error = 'FUCK OFF';
    } else {
      $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");

      $query->bindvalue(1, $user);
      $query->execute();
      $payload = $query->fetch();
      $hashedpass = $payload['hash'];

      if ($user && password_verify($pass, $hashedpass)) {

        $_SESSION['logged_in_booker'] = true;
        $_SESSION['user'] = $user;
        header('Location: booker.php');
        exit();

      } else {
        $error = 'Go away asshole';

      }

    }

  }

?>

<html>
  <head>
    <title>Booker Mackenzie</title>
    <!-- Style sheet -->
    <link rel="stylesheet" href="style.css">

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

<!-- Error goes here if there is one -->
<?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
<?php      } ?>

<!-- Login form -->

<div>
<form action="index.php" method="post" autocomplete="off">
  <input type="text" name="user" placeholder="Who are you..."/>
  <br>
  <input type="password" name="pass" placeholder="Password..."/>
  <br>
  <input type="submit" value="Log into Booker" />
</form>
</div>




</html>

<?php
}
?>
