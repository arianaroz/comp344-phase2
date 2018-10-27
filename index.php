<?php
<<<<<<< HEAD
    //include("db.php");
    include("common_db.php");
    include("functions.php"); ?>
=======
require_once("common_db.php");
require_once("SessionManager.php");

include("functions.php");
include("config.php");


if(store_get_shopper_id() > 0){
    echo "you are logged in";
}
else {
    echo " you are not logged in";
}


if(isset($_POST['logout'])){
    logout();
}
?>
>>>>>>> 53c3f30bba497642ced1065b169b7f881fe13954

<html>
<head>
  <link rel="stylesheet" type="text/css" href="style1.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

<title><?= $store_name ?></title>
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

</div>
<div class="footer">
<?php include("footer.php"); ?>
</div>
</html>
