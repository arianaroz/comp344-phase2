<?php
include_once("common_db.php");
include_once("SessionManager.php");
include_once("config.php");
$db= db_connect();
$user = "";
$message = "";
if(store_get_shopper_id() <0){
    header('location: signin.php');
    exit();
}
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

    //insert the new address into the Shaddr table according to shopper id
    $sql= "INSERT INTO Shaddr (shopper_id, sh_title, sh_firstname, sh_familyname, sh_street1, sh_street2, sh_city, sh_state, sh_postcode, sh_country)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt= $db->prepare($sql);
    $stmt->execute(array($sid, $title, $firstname, $lastname,$street1, $street2,$city,$state,$postcode,$country));

    $message= "";
}

//delete an address
if(isset($_POST['remove'])){
    $a = $_POST['shaddr_id'];

    $sql = "DELETE FROM Shaddr WHERE shaddr_id = :addid";
    $stmt= $db->prepare($sql);
    $statement->bindParam('addid',$a);
    $stmt->execute($sql);

    $message="Address removed.";
    header('location: addressBook.php');
}

//call logout function
if(isset($_POST['logout'])){
    logout();

    header('location: signin.php');
    exit();
}

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
<link rel=:script href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" />
<script type="text/javascript" src="validation.js" ></script>
<script type="text/javascript">
//show the address book form
function show(){
    document.getElementById("myModal").classList.add('is-active');

    }
//close the address form
function hide(){
    document.getElementById("myModal").classList.remove('is-active');

}
</script>
</head>


<body>
<?php include("header.php"); ?>
<section class="hero has-background-white-bis is-large">
<div class="level-right" id="user"> Welcome <?php echo $user ?> </div>
<?php include("menu.php")?>

<div class="hero-body is-large">
    <div class="addresses">
    <table>
    <th id="t">Addresses</th>
</br>
    <?php
    $db= db_connect();
    //retrieve users addresses
    $sql=("SELECT shaddr_id, sh_title, sh_firstname, sh_familyname, sh_street1, sh_street2, sh_city, sh_state, sh_postcode, sh_country
        FROM Shaddr WHERE shopper_id = :sid");
        try{
        $stmt = $db->prepare($sql);
        $stmt->bindParam('sid',$sid);
		$stmt->execute();
    }
    catch (PDOException $ex) {
		echo $ex->getMessage();
		die ("Invalid query");
	}

    //display address
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //show addresses below
    ?>
    <tr><td></br></td></tr>
    <tr>
    <form action="POST" action="addressBook.php">
        <td>
        <?= $addid= $row['shaddr_id'];?>
        <?=$row['sh_title']; ?>
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

        <td> <?=$row['sh_country'];?></td>
        <td><button id="delete"class="button is-danger is-outlined is-right" type="submit" name="remove"> Remove</button></td>
    </tr>
</form>
    <tr>
        <td>

        </tr>
    <tr><td></br></td></tr>
    <th id="b"></th>
    <?php
    }
   ?>

</table>
</br>
<?php echo $message ?>
<button class="button is-fullwidth is-primary is-outlined" id="add" onclick="show();"> Add an address</button>
</div>
<div>
</div>
</div>

<div class="modal" id="myModal">
<div class="modal-background"></div>
<div class="modal-content">
    <h5 id="A" class="title is-5">Add an address</h5>
        <form class="addAddress" method="post" action="">
        <div class="field is-horizontal">
            <div class="field-body">
            <input class="input" id="title" type="text" name="title" maxlength="4" placeholder="Title" required>
        </div>
      <div class="field-body">
        <div class="field">
            <input class="input" type="text" id="first"  name="firstname" placeholder="Firstname" required>
        </div>
        <div class="field">
            <input class="input" type="text" id="last" name="lastname" placeholder="Lastname" required>
        </div>
      </div>
  </div>
<div class="field is-horizontal">
    <div class="field-body">
      <div class="field">
          <input class="input" type="text" id="street1" name="street1" placeholder="Address line 1" required>
      </div>
  </div>
</div>
      <div class="field is-horizontal">
         <div class="field-body">
      <div class="field">
          <input class="input" type="text" id="street2" name="street2"placeholder="Address line 2" >
      </div>
    </div>
  </div>
  <div class="field is-horizontal">
      <div class="field-body">
        <div class="field">
            <input class="input" type="text" id="city" name="city"placeholder="City" required>
        </div>
        <div class="field">
            <input class="input" type="text" id="state" name="state" placeholder="State" required>
        </div>
    </div>
    </div>

    <div class="field-body">
    <div class="field">
        <input class="input" type="text" id="country" name="country" placeholder="Country" required>
      </div>
      <div class="field">
          <input class="input" type="text" id="postcode" name="postcode" maxlength="4" placeholder="Postcode" >
      </div>
  </div>
</br>
 <div class="field is-horizontal">
<div class="field-body">
  <div class="field">
    <p class="control">
      <button class="button is-fullwidth has-background-primary" onclick="return addressValidate();" type="submit" name="submit">Save address</button>
    </p>
  </div>
</div>
</form>
</div>
</div>
<button class="modal-close is-large" onclick="hide();"aria-label="close"></button>

</div>
</div>
</section>

<div class="footer">
<?php include("footer.php"); ?>
</div>
</body>
</html>
