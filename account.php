<?php
require_once("common_db.php");
require("SessionManager.php");
require_once("config.php");

$db= db_connect();
$user = "";

if(store_get_shopper_id() > 0){
    //Get the shopper_id of current logged in user from the session table
    $sid = store_get_shopper_id();
    //select username according to shopper_id
    $stmt = $db->prepare("SELECT sh_username FROM Shopper WHERE shopper_id = ?");
    $stmt->execute(array($sid));

    $res= $stmt->fetchAll(PDO::FETCH_ASSOC);

    //display username
    foreach ($res as $row){
        $user= $row['sh_username'];
    }

    $stmt = $db->prepare("SELECT sh_username, sh_email, sh_phone FROM Shopper WHERE shopper_id = ?");
    $stmt->execute(array($sid));
    $res= $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($res as $row){
        $username= $row['sh_username'];
        $email=$row['sh_email'];
        $phone=$row['sh_phone'];
    }


}
else {
    header('Location: signin.php');
    exit();
}

if(isset($_POST['logout'])){
    logout();

    header('location: signin.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $store_name ?> Address Book</title>
<link rel="stylesheet" type="text/css" href="style1.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>

<body>
<?php include("header.php"); ?>
<section class="hero has-background-white-bis is-medium">
<div class="level-right" id="user"> Welcome <?php echo $user ?> </div>
<?php include("menu.php") ?>
<div class="hero-body">

    <div class="details">
      <div> Username: <?php echo $username ?> </div>
  </br>
        <div>Email:  <?php echo $email ?></div>
    </br>
        <div>Phone:  <?php echo $phone ?></div>
    </br>

    </div>
</div>
</section>
<div class="footer">
<?php include("footer.php"); ?>
</div>
</body>
</html>
