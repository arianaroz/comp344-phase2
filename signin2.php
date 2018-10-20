<?php

include("db.php");
    include("login.php");
    $username = $_POST[‘username’];
    $password = $_POST[‘password’];

    if(isset($_POST['login'])){
        login($username, $password);
    }



?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

</head>

<script type="text/javascript">
</script>

<body>
<section class="hero has-background-white-bis is-medium">
    <div class="hero-body">
        <div class="logincontainer has-background-white">
            <h5 class="title is-5">Sign in</h5>
         <div class="columns is-centered">
              <div class="card-content">

            <div class="field ">
  <p class="control has-icons-left ">
    <input class="input" type="text" placeholder="Username">
    <span class="icon is-small is-left">
      <i class="fas fa-user"></i>
  </span>
  </p>
</div>
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="password" placeholder="Password">
    <span class="icon is-small is-left">
      <i class="fas fa-lock"></i>
    </span>
  </p>
</div>
<div class="field">
  <p class="control">
    <button class="button is-fullwidth has-background-primary">
      Login
    </button>
  </p>
</div>

<div class="field ">
    <div class="is-size-7" id="passlink"> <a id="passwordlink" href=""> Forgot your password? </a> </div>
    <div class="is-size-7" id="link">Don't have an account? <a id="registerlink" href="register.php">Sign Up</a></div>
</div>
</div>
</div>
</div>


</div>
</div>
</section

<div class="footer">
<?php include("footer.php"); ?>
</div>

</body>
</html>
