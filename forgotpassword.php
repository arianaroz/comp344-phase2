<?php
include_once("common_db.php");
include_once("functions.php");
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot Password</title>
<link rel="stylesheet" type="text/css" href="style1.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<script type="text/javascript" src="validation.js" ></script>
</head>

<?php include("header.php"); ?>
<body>
  <section class="hero has-background-white-bis is-medium">
    <div class="hero-body">
      <div class="logincontainer has-background-white">
        <h5 class="title is-5">Forgot Password</h5>

        <div id="s" >
          <div class="is-size-7"> Please enter your email address.</div>
          <div class="is-size-7"> We will send you instructions to reset your password. </div>
          <div class="regi_errror"></div>
          <div class="columns is-centered">
            <div class="card-content">
              <div class="field ">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="form">
                  <p class="control has-icons-left ">
                    <input class="input" id="email" type="email" name="email" placeholder="Email" required>
                    <span class="icon is-small is-left">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </p>
                </div>

                <div class="field">
                  <p class="control">
                    <button class="button is-fullwidth has-background-primary"  onclick="return emailValidate();" type="submit" name="submit">Submit</button>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="field">
          <div class="is-size-7" id="link"> <a id="goBack" href="signin.php">Go Back</a></div>
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
  //User submits email in form
  if (isset($_POST['submit'])){
    $_email = $_POST['email'];

    // PHP email validation function
    if (email_validation($_email)==false) {
      return;
    }
    //db connection
    $db = db_connect();

    // Query to check if user email address already exists in the database
    $stmt = $db->prepare("SELECT sh_email, shopper_id FROM Shopper WHERE sh_email= ?");
    $stmt->execute(array($_email));
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the return result is not empty
    if (!empty($res)) {
      $sql_email = $res["sh_email"];
      $shopper_id = $res["shopper_id"];
    }
    // If users email not in the database
    else {
      echo "
      <div class='regi_error'>
      Email address does not exist in the system.
      </div>
      ";
      return ;
    }

    // Delete the row if token already exists for the specefic user_id
    $stmt = $db->prepare("DELETE FROM pass_session WHERE user_id= ?");
    $stmt->execute(array($shopper_id));

    // Random string generator for generating token
    $token = md5(uniqid(rand(), true));
    // Adds an extra 24 hours to the current time
    $nextDay = time() + (1 * 24 * 60 * 60);
    // Gets the current date and time and adds the extra 24 hours
    // It gives the user a day of expiry time to use the token
    $exp_time = Date('Y-m-d H:i:s', $nextDay);

    // Query to put the reset password token into the database
    $stmt = $db->prepare("INSERT INTO pass_session VALUES (?, ?, ?)");

    // If insertion is successful
    if ($stmt->execute(array($shopper_id, $token, $exp_time))) {

      // Token URL Generation
      $get_uri=$_SERVER['REQUEST_URI'];
      $uri = "".$get_uri;
      $uri = substr($uri, 0, -18);
      $url = 'https://platypus.science.mq.edu.au' . $uri . 'resetpassword.php?token=' . $token;

      // EMAIL CONFIRMATION
      $msg = "Here is your password reset link: " . $url . ". From: Super Notebook Store";
      mail($_email,'Password Reset',$msg);

      
        header('Location: resetLinkSuccess.php');
        exit();

    }

  }

?>
