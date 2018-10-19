<?php session_start(); ?>
<?php if(isset($_SESSION['email'])){
    header("Location: /index.php");
    exit;
}
?>
<?php include("db.php");
include("functions.php");?>

<html>
<head>
  <!-- <script type="text/javascript" src="validation.js" ></script> -->
  <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <title>Register</title>
</head>
<body>

  <div class="registration">
    <div class="heading_regi">Register</div>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <input id ="username" type="text" name="username" placeholder="Username" required><br/>
    <!-- <div class="tagline">Ex: John Smith</div> -->
    <input id ="email" type="email" name="email" placeholder="MQ Email" required><br/>
    <!-- <div class="tagline">Ex: firstname.lastname@mq.edu.au</div> -->
    <input id ="phone" type="tel" name="phone" placeholder="Phone Number" required><br/>
    <input id ="password" type="password" name="password" placeholder="Password" required><br/>
    <!-- <div class="tagline">6 - 10 characters, must contain at least one number and starts with an alphabet</div> -->
    <div class="g-recaptcha" data-sitekey="6LenP3UUAAAAAD2ss0_c0u4509yIayZT2nvLqr9v"></div>
    <input type="submit" name="reg_button" value="Register" />
  </form>
  <div id="rerr" class="regi_error"></div>
  </div>
</body>
</html>

<?php
  if (isset($_POST['reg_button'])){

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
        // If CAPTCHA is successfully completed...

        $_username = $_POST['username'];
        $_email = $_POST['email'];
        $_phone = $_POST['phone'];
        $_password = $_POST['password'];


        // if (name_validation($_username)==false){
        //   return;
        // }
        if (email_validation($_email)==false) {
          return;
        }
        elseif (password_validation($_password)==false) {
          return;
        }

        $hashed_password = password_hash($_password, PASSWORD_DEFAULT);

        $query_chk = "SELECT sh_email FROM Shopper WHERE sh_email='$_email'";
        $result_chk = mysqli_query($conn, $query_chk);

        if (mysqli_num_rows($result_chk) > 0) {
          // output data of each row
          while($xrow = mysqli_fetch_assoc($result_chk)) {
            $sql_email = $xrow["email"];
          }
          if ($sql_email==$_email){
            echo "
            <div class='regi_error'>
            Email address is already registered.
            </div>
            ";
            return ;
          }
        }

        $query_chk = "SELECT sh_username FROM Shopper WHERE sh_username='$_username'";
        $result_chk = mysqli_query($conn, $query_chk);

        if (mysqli_num_rows($result_chk) > 0) {
          // output data of each row
          while($xrow = mysqli_fetch_assoc($result_chk)) {
            $sql_username = $xrow["sh_username"];
          }
          if ($sql_username==$_username){
            echo "
            <div class='regi_error'>
            Username already exists.
            </div>
            ";
            return ;
          }
        }


        $query = "INSERT INTO Shopper (shopper_id, sh_username, sh_password, sh_email, sh_phone, sh_type, sh_shopgrp, sh_field1, sh_field2)
        VALUES ('1', '$_username', '$hashed_password', '$_email', '$_phone', 'x', '1', 'a', 'b')";


        if (mysqli_query($conn, $query)) {
          $_SESSION['email'] = $_POST['email'];

          //EMAIL CONFIRMATION
          // $msg = "Thank you for your registration. Your user name is: " . $_email . ". From: mohammed.tanvir-hossain@students.mq.edu.au";
          // mail($_email,'Registration Successful',$msg,'From: mohammed.tanvir-hossain@students.mq.edu.au','-f mohammed.tanvir-hossain@students.mq.edu.au');

          echo "<script>window.location = '/index.php'</script>";

        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        //mysqli_close($conn);
        }
    }




?>
