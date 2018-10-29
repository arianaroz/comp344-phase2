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
}
else {
    header('Location: signin.php');
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
<?php include("menu.php")?>
    <div class="hero-body">
    <div class="address is-centered">
    <h5 class="title is-5">Add an address</h5>
        <form>
            <div class="field is-horizontal">
      <div class="field-body">
        <div class="field">
            <input class="input" type="text" placeholder="Firstname" required>
        </div>
        <div class="field">
            <input class="input" type="email" placeholder="Lastname" required>
        </div>
      </div>
  </div>

<div class="field is-horizontal">
    <div class="field-body">
      <div class="field">
          <input class="input" type="text" placeholder="Address line 1" required>
      </div>
  </div>
</div>
      <div class="field is-horizontal">
         <div class="field-body">
      <div class="field">
          <input class="input" type="text" placeholder="Address line 2" >
      </div>
    </div>
  </div>
  <div class="field is-horizontal">
      <div class="field-body">
        <div class="field">
            <input class="input" type="text" placeholder="City" required>
        </div>
        <div class="field">
            <input class="input" type="text" placeholder="State" required>
        </div>
    </div>
    </div>

    <div class="field-body">
    <div class="field">
        <div class="select is-fullwidth" id="country">
            <select>
                <option>Country</option>
                <option>Australia</option>
                <option>New Zealand</option>
            </select>
        </div>
      </div>
      <div class="field">
          <input class="input" type="text" placeholder="Postcode" >
      </div>
  </div>
</br>
 <div class="field is-horizontal">
<div class="field-body">
  <div class="field">
    <p class="control">
      <button class="button is-fullwidth has-background-primary" type="submit" name="login">Save address</button>
    </p>
  </div>
</div>
</form>
</div>
</section>

<div class="footer">
<?php include("footer.php"); ?>
</div>
</body>
</html>
