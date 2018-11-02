<?php

include_once("common_db.php");
include("functions.php");

?>

<html>
<head>
  <script type="text/javascript" src="validation.js" ></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>


  <title>Reset Password</title>

</head>
<?php include("header.php"); ?>
<body>
  <section class="hero has-background-white-bis is-medium">
    <div class="hero-body">

      <div class="reset has-background-white">
        <div class="columns is-centered">
          <div class="card-content">
            <h5 class="title is-5">Reset Password</h5>

            <form class="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="field">
                <input class="input" id ="password" type="password" name="password" placeholder="New Password" required><br/>
              </div>
              <div class="field">
                <input class="input" id ="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm password" required><br/>
              </div>
              <div class="field">
                <button class="button is-fullwidth has-background-primary" type="submit" onclick="return validate_reset();" class="button" name="reset">Reset Password</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


  <div class="footer">
    <?php include("footer.php"); ?>
  </div>
</body>
</html>
<?php
// Getting password token from the URL and putting in the session variable
if (isset($_GET['token'])){
  $_SESSION['token'] = $token = $_GET['token'];
}
?>

<?php
$db = db_connect();
if (isset($_POST['reset'])){

  $_password = $_POST['password'];
  $_confirmPass = $_POST['confirmPassword'];
  // Getting the token from session variable
  $token = $_SESSION['token'];
  // Destrying the session token variable
  session_destroy();

  // PHP password validation functions
  if (password_validation($_password)==false) {
    return;
  }
  elseif (passwordCheck($_password, $_confirmPass)== false){
      return;
  }

  // Hashing password
  $hashed_password = password_hash($_password, PASSWORD_DEFAULT);

  // Query to get user id and timestamp for resetting password from the database
  $stmt = $db->prepare("SELECT user_id, timestamp FROM pass_session WHERE token= ?");
  $stmt->execute(array($token));
  $res = $stmt->fetch(PDO::FETCH_ASSOC);

  // If the return result is not empty
  if (!empty($res)) {
    $user_id = $res["user_id"];
    $exp_time = $res["timestamp"];
  }

  // Gets the current time
  $now_time = date('Y-m-d H:i:s');
  // Checks if the current time passed than token expiry time
  if($now_time>$exp_time){
    echo "Sorry your token has been expired.";
    $stmt = $db->prepare("DELETE FROM pass_session WHERE token= ?");
    $stmt->execute(array($token));
    return ;
  }

  // Query to update the password
  $stmt = $db->prepare("UPDATE Shopper SET sh_password= ? WHERE shopper_id= ?");

  // If updating is successful
  if ($stmt->execute(array($hashed_password, $user_id))) {
    // Deletes the used token
    $stmt = $db->prepare("DELETE FROM pass_session WHERE token= ?");
    $stmt->execute(array($token));

    // Grabbing location
    $get_uri=$_SERVER['REQUEST_URI'];
    $uri = "".$get_uri;
    $uri = substr($uri, 0, -17);
    $url = 'https://platypus.science.mq.edu.au' . $uri . 'index.php';

    // Redirects to the home page
    echo "<script>window.location = '$url'</script>";

  }


}

?>
