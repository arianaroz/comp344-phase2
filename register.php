<?php

include_once("common_db.php");
include_once("functions.php");

?>

<html>
<head>
  <script type="text/javascript" src="validation.js" ></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
  <script src='https://www.google.com/recaptcha/api.js'></script>


  <title>Register</title>
</head>
<?php include("header.php"); ?>
<body>
  <section class="hero has-background-white-bis is-medium">
    <div class="hero-body">

      <div class="registration has-background-white">
        <div class="columns is-centered">
          <div class="card-content">
            <h5 class="title is-5">Create an account</h5>
            <div class="regi_error"> </div>
            <form class="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

              <div class="field">
                <input class="input" id ="username" type="text" name="username" placeholder="Username" required><br/>
                    <div class="control"><span class="is-size-7">Minimum 4 characters</span></div>
              </div>

              <div class="field">
                <input class="input" id ="email" type="email" name="email" placeholder="Email Address" required><br/>
              </div>

              <div class="field">
                <input class="input" id ="phone" type="tel" name="phone" placeholder="Phone Number" required><br/>
              </div>
              <div class="field">
                <input class="input" id ="password" type="password" name="password" placeholder="Password" required><br/>
                <div class="control"><span class="is-size-7">Minimum 8 characters</span></div>
              </div>
              <div class="field">
                <input class="input" id ="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm password" required><br/>
              </div>
              <!-- Google reCaptcha box -->
              <div class="field">
                <div class="g-recaptcha" data-sitekey="6LeHUngUAAAAABmA-gghmH-t2WaGEOMB5_r6wn91"></div>
              </div>
              <div class="field">
                <button class="button is-fullwidth has-background-primary" type="submit" onclick="return validate_registration();" class="button" name="reg_button">Register </button>
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
// Making db connection
$db = db_connect();

// If registration submit button is pressed
if (isset($_POST['reg_button'])){
  // Calling Google reCaptcha
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
    //your site secret key
    $secret = '6LeHUngUAAAAAN1_ngWnbywpJFP30EdX5Z12GdzR';
    //get verify response data
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if($responseData->success){
      $_username = $_POST['username'];
      $_email = $_POST['email'];
      $_phone = $_POST['phone'];
      $_password = $_POST['password'];
      $_confirmPass = $_POST['confirmPassword'];

      // PHP text validation functions
      if (username_validation($_username)==false){
        return;
      }
      elseif (email_validation($_email)==false) {
        return;
      }
      elseif (password_validation($_password)==false) {
        return;
      }
      elseif (phone_validation($_phone)==false) {
        return;
      }
      elseif (passwordCheck($_password, $_confirmPass)== false){
        return;
      }

      // Hashing password
      $hashed_password = password_hash($_password, PASSWORD_DEFAULT);

      // Query to check if user email address already exists in the database
      $stmt = $db->prepare("SELECT sh_email FROM Shopper WHERE sh_email= ?");
      $stmt->execute(array($_email));
      $res = $stmt->fetch(PDO::FETCH_ASSOC);

      // If the return result is not empty
      if (!empty($res)) {
        $sql_email = $res["sh_email"];
        if ($sql_email==$_email){
          echo "
          <div class='regi_error'>
          Email address is already registered.
          </div>
          ";
          return ;
        }
      }

      // Query to check if username already exists in the database
      $stmt = $db->prepare("SELECT sh_username FROM Shopper WHERE sh_username= ?");
      $stmt->execute(array($_username));
      $res = $stmt->fetch(PDO::FETCH_ASSOC);

      // If the return result is not empty
      if (!empty($res)) {
        $sql_username = $res["sh_username"];

        if ($sql_username==$_username){
          echo "
          <div class='regi_error'>
          Username already exists.
          </div>
          ";
          return ;
        }
      }

      // Query to insert form data into the database
      $stmt = $db->prepare("INSERT INTO Shopper (shopper_id, sh_username, sh_password, sh_email, sh_phone, sh_type, sh_shopgrp, sh_field1, sh_field2)
      VALUES (Null, ?, ?, ?, ?, 'x', '1', Null, Null)");

      // If insertion of data is Successful
      if ($stmt->execute(array($_username, $hashed_password, $_email, $_phone))) {

        // EMAIL CONFIRMATION
        $msg = "Thank you for your registration. Your username is: " . $_username . ". From: Super Notebook Store";
        mail($_email,'Registration Successful',$msg);

        // Redirects to the registration successful page
        $get_uri=$_SERVER['REQUEST_URI'];
        $uri = "".$get_uri;
        $uri = substr($uri, 0, -12);
        $url = 'https://platypus.science.mq.edu.au' . $uri . 'regSuccess.php';
        echo "<script>window.location = '$url'</script>";

      }
    }
    else {
      echo "Wrong reCaptcha";
      return ;
    }
  }
  else {
    echo "Wrong reCaptcha";
    return ;
  }

}

?>
