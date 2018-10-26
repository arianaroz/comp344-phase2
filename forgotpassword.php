<?php
include("db.php");
$error= "";




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


<body>

  <section class="hero has-background-white-bis is-medium">
    <div class="hero-body">
      <div class="logincontainer has-background-white">
        <h5 class="title is-5">Forgot Password</h5>

        <div id="s" >
          <div class="is-size-7"> Please enter your email address.</div>
          <div class="is-size-7"> We will send you instructions to reset your password. </div>
          <div class="error"><?php echo $error;?></div>
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
  if (isset($_POST['submit'])){
    $_email = $_POST['email'];
    $query_chk = "SELECT sh_email, shopper_id FROM Shopper WHERE sh_email='$_email'";
    $result_chk = mysqli_query($conn, $query_chk);

    if (mysqli_num_rows($result_chk) > 0) {
      // output data of each row
      while($xrow = mysqli_fetch_assoc($result_chk)) {
        $sql_email = $xrow["sh_email"];
        $shopper_id = $xrow["shopper_id"];
      }
    }
    else {
      echo "
      <div class='regi_error'>
      Email address does not exist in the system.
      </div>
      ";
      return ;
    }

    // Delete the row if token already exists for the specefic user_id
    $query_dlt = "DELETE FROM pass_session WHERE user_id='$shopper_id'";
    mysqli_query($conn, $query_dlt);

    $token = md5(uniqid(rand(), true));
    //$nextDay = time() + (1 * 24 * 60 * 60);
    $nextDay = time() + (120);
    $exp_time = date('Y-m-d H:i:s', $nextDay);
    $query = "INSERT INTO pass_session VALUES ('$shopper_id', '$token', '$exp_time')";
    if (mysqli_query($conn, $query)) {

      //EMAIL CONFIRMATION
      // $msg = "Thank you for your registration. Your user name is: " . $_email . ". From: mohammed.tanvir-hossain@students.mq.edu.au";
      // mail($_email,'Registration Successful',$msg,'From: mohammed.tanvir-hossain@students.mq.edu.au','-f mohammed.tanvir-hossain@students.mq.edu.au');

      echo "<script>window.location = '/index.php'</script>";

    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

  }

?>
