<?php session_start(); ?>
<?php include("db.php");
    include("common_db.php");
include("functions.php"); ?>

<html>
<head>
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
  <title>Macquarie University Online Store - Phase 2</title>
</head>
<body>
This is the homepage.
<form method="post">
  <input id="nav_but" type="submit" name="logout" value="Logout" />
</form>
</body>
<?php
if (isset($_POST['logout'])){
  session_destroy();
  echo "<script>window.location = '/register.php'</script>";
}
?>
</html>
