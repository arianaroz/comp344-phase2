<?php session_start();

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
              </div>

              <div class="field">
                <input class="input" id ="email" type="email" name="email" placeholder="Email Address" required><br/>
              </div>

              <div class="field">
                <input class="input" id ="phone" type="tel" name="phone" placeholder="Phone Number" required><br/>
              </div>
              <div class="field">
                <input class="input" id ="password" type="password" name="password" placeholder="Password" required><br/>
              </div>
              <div class="field">
                <input class="input" id ="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm password" required><br/>
              </div>
              <!-- Google reCaptcha box -->
              <div class="field">
                <div class="g-recaptcha" data-sitekey="6LenP3UUAAAAAD2ss0_c0u4509yIayZT2nvLqr9v"></div>
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
  function post_captcha($user_response) {

    $fields_string = '';
    $fields = array(
      'secret' => '6LenP3UUAAAAAMd4vRvG00HfCIuToEXz-Kb2wMib',
      'response' => $user_response
    );
    foreach($fields as $key=>$value)
    $fields_string .= $key . '=' . $value . '&';
    $fields_string = rtrim($fields_string, '&');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
  }

  // Call the function post_captcha
  $res = post_captcha($_POST['g-recaptcha-response']);

  if (!$res['success']) {
    // What happens when the CAPTCHA wasn't checked
    echo '<p>Wrong reCAPTCHA Input</p><br>';
  } else {
    // If CAPTCHA is successfully completed

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
      // $msg = "Thank you for your registration. Your username is: " . $_username . ". From: Super Notebook Store";
      // mail($_email,'Registration Successful',$msg);

      // Redirects to the registration successful page
      echo "<script>window.location = '/regSuccess.php'</script>";

    }

  }
}

?>
