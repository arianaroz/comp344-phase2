<?php session_start();

include_once("common_db.php");
include("functions.php");

// if(isset($_SESSION['email'])){
//   header("Location: /index.php");
//   exit;
//
// }
?>

<html>
<head>
  <!-- <script type="text/javascript" src="validation.js" ></script> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>


  <title>Reset Password</title>
</head>
<body>
  <section class="hero has-background-white-bis is-large">
    <div class="hero-body">

      <div class="registration has-background-white">
        <div class="columns is-centered">
          <div class="card-content">
            <h5 class="title is-5">Reset Password</h5>
            <div class="regi_error"> <?php echo $error ?></div>
            <form class="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="field">
                <input class="input" id ="password" type="password" name="password" placeholder="New Password" required><br/>
              </div>
              <div class="field">
                <input class="input" id ="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm password" required><br/>
              </div>
              <!-- <div class="tagline">6 - 10 characters, must contain at least one number and starts with an alphabet</div> -->
              <div class="field">
                <button class="button is-fullwidth has-background-primary" type="submit" class="button" name="reset">Reset Password</button>
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
if (isset($_GET['token'])){
  $_SESSION['token'] = $token = $_GET['token'];
}


?>

<?php
$db = db_connect();
if (isset($_POST['reset'])){

  $_password = $_POST['password'];
  $_confirmPass = $_POST['confirmPassword'];
  $token = $_SESSION['token'];
  //echo "$token";
  session_destroy();

  // if (name_validation($_username)==false){
  //   return;
  // }
  // if (email_validation($_email)==false) {
  //   return;
  // }
  // elseif (password_validation($_password)==false) {
  //   return;
  //
  // }
  // elseif (passwordCheck($_password, $_confirmPass)== false){
  //     return;
  // }

  $hashed_password = password_hash($_password, PASSWORD_DEFAULT);

  $stmt = $db->prepare("SELECT user_id, timestamp FROM pass_session WHERE token= ?");
  $stmt->execute(array($token));
  $res = $stmt->fetch(PDO::FETCH_ASSOC);


  if (!empty($res)) {
    $user_id = $res["user_id"];
    $exp_time = $res["timestamp"];
  }

  $now_time = date('Y-m-d H:i:s');
  if($now_time>$exp_time){
    echo "Sorry your token has been expired.";
    $stmt = $db->prepare("DELETE FROM pass_session WHERE token= ?");
    $stmt->execute(array($token));
    return ;
  }

  $stmt = $db->prepare("UPDATE Shopper SET sh_password= ?");



  if ($stmt->execute(array($hashed_password))) {
    $stmt = $db->prepare("DELETE FROM pass_session WHERE token='$token'");
    $stmt->execute(array($token));

    echo "<script>window.location = '/index.php'</script>";

  }

  //mysqli_close($conn);

}




?>
