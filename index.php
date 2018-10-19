<?php session_start(); ?>
<?php
    include("db.php");
include("functions.php"); ?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css1">
  <title>Macquarie University Online Store - Phase 2</title>
</head>

<div class="wrapper">
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

</div>
<div id="footer">
<?php include("footer.php"); ?>
</div>
</html>
