<?php
include_once("common_db.php");
include_once("SessionManager.php");
include_once("config.php");
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

    //retrieve users addresses
    $stmt = $db->prepare("SELECT sh_title, sh_firstname, sh_familyname, sh_street1, sh_street2, sh_city, sh_state, sh_postcode, sh_country
        FROM Shaddr WHERE shopper_id = ?");
    $stmt->execute(array($sid));

    $stmt->fetch(PDO::FETCH_ASSOC);

    //check for address results and output
    if($stmt->rowCount() > 0){
        //show addresses
    }
    //if no addresses are saved
    else if($stmt->rowCount() <0){
            echo " you have no addresses saved.";
    }
  }

  else {
    header('Location: signin.php');
    exit();
}

if(isset($_POST['submit'])){
    $title= $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $street1 = $_POST['street1'];
    $street2 = $_POST['street2'];
    $city= $_POST['city'];
    $state = $_POST['state'];
    $postcode= $_POST['postcode'];
    $country= $_POST['country'];


    $sql= "INSERT INTO Shaddr (shopper_id, sh_title, sh_firstname, sh_familyname, sh_street1, sh_street2, sh_city, sh_state, sh_postcode, sh_country)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt= $db->prepare($sql);
    $stmt->execute(array($sid, $title, $firstname, $lastname,$street1, $street2,$city,$state,$postcode,$country));

}



if(isset($_POST['logout'])){
    logout();

    header('location: signin.php');
    exit();
}


?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $store_name ?> Address Book</title>
<link rel="stylesheet" type="text/css" href="style1.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<script src="text/javascript">
</script>

<body>
<?php include("header.php"); ?>
<section class="hero has-background-white-bis is-large">
    <div class="level-right" id="user"> Welcome <?php echo $user ?> </div>
<?php include("menu.php")?>


<div class="hero-body is-small">
    <div class ="addresses">
    <table>
    <colgroup>
    <th id="t">Addresses</th>
</colgroup>
    <?php
    foreach($stmt as $row)  {?>
    <tr><td></br></td></tr>
    <tr>
        <td><?=$row['sh_title']; ?>
        <?=$row['sh_firstname'];?>
         <?=$row['sh_familyname'];?>
     </td></tr>
     <tr>
         <td>
         <?=$row['sh_street1'];?>
         </td>
    </tr>
    <tr>
        <td><?=$row['sh_street2'];?> </td>
    </tr>
    <tr>
        <td> <?=$row['sh_city'];?></td></tr>
    <tr>
        <td>
        <?=$row['sh_state'];?>
        <?=$row['sh_postcode'];?></td>
    </tr>
    <tr>
        <td> <?=$row['sh_country'];?> </td>
    </tr>
    <tr>
        <td>

        </tr>
    <tr><td></br></td></tr>
    <th id="b"></th>
    <?php
        } ?>

</table>
</br>

</div>
</div>
<div class="address is-centered " id="add1">
    <h5 class="title is-5">Add an address</h5>
        <form method="post" action="addressBook.php">
        <div class="field is-horizontal">
            <div class="field-body">
            <input class="input" id="title" type="text" name="title" placeholder="Title" required>
        </div>
      <div class="field-body">
        <div class="field">
            <input class="input" type="text" id="first"  name="firstname" placeholder="Firstname" required>
        </div>
        <div class="field">
            <input class="input" type="text"id="last" name="lastname" placeholder="Lastname" required>
        </div>
      </div>
  </div>
<div class="field is-horizontal">
    <div class="field-body">
      <div class="field">
          <input class="input" type="text" name="street1" placeholder="Address line 1" required>
      </div>
  </div>
</div>
      <div class="field is-horizontal">
         <div class="field-body">
      <div class="field">
          <input class="input" type="text" name="street2"placeholder="Address line 2" >
      </div>
    </div>
  </div>
  <div class="field is-horizontal">
      <div class="field-body">
        <div class="field">
            <input class="input" type="text" name="city"placeholder="City" required>
        </div>
        <div class="field">
            <input class="input" type="text" name="state" placeholder="State" required>
        </div>
    </div>
    </div>

    <div class="field-body">
    <div class="field">
        <input class="input" type="text" name="country" placeholder="Country" required>
      </div>
      <div class="field">
          <input class="input" type="text" name="postcode" placeholder="Postcode" >
      </div>
  </div>
</br>
 <div class="field is-horizontal">
<div class="field-body">
  <div class="field">
    <p class="control">
      <button class="button is-fullwidth has-background-primary" type="submit" name="submit">Save address</button>
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
