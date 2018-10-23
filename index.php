<?php session_start(); ?>
<?php
    include("db.php");
include("functions.php"); ?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="style1.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">


  <title>Macquarie University Online Store - Phase 2</title>
</head>

<body>
    <section class="hero has-background-white-bis is-large">
        <div class="hero-body">
            <div class="container">
                <form method="post">
                    This is the homepage.

                  <input id="nav_but" type="submit" name="logout" value="Logout" />
                </form>
          </div>
        </div>
    </section>










</body>
<?php
if (isset($_POST['logout'])){
  session_destroy();
  echo "<script>window.location = '/register.php'</script>";
}
?>

</div>
<div class="footer">
<?php include("footer.php"); ?>
</div>
</html>
