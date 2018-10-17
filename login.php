<?php

include("common_db.php");


if(isset($_POST['login'])){

$username= $_POST['username'];
$password= $_POST['password'];

$query= "select shopper_id, sh_password FROM Shopper WHERE sh_username=?";


$result = $conn->query($query);

if($result->num_rows == 0){
  $error ="Incorrect username";
}

?>

<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="style1.css" >
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<script type="text/javascript">

</script>



<div class="loginContainer">

<form class="signin" method="POST">
      <h2 class="signin-heading">Sign In</h2>
      <div class="error"><?php echo $error;?></div>
      <div class="input-group">
    <input type="text" name="username" class="login-form" placeholder="Username" required>
  </div>
  <div>
      <input type="password" name="password" id="inputPassword" class="login-form" placeholder="Password" required>
     <div> <button id="login-btn" class="button" type="submit" name="login">Sign In</button> </div>
     <div id="link">Don't have an account? <a id="registerlink" href="register.php">Sign Up</a></div>
     </div>
    </form>

    
</div>

</body>
</html>
