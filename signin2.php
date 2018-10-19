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
<section class="hero has-background-white-bis is-large">
    <div class="hero-body">
         <div class="columns is-centered">
              <div class="card-content">

            <div class="field">
  <p class="control has-icons-left has-icons-right">
    <input class="input" type="email" placeholder="Email">
    <span class="icon is-small is-left">
      <i class="fas fa-envelope"></i>
    </span>
    <span class="icon is-small is-right">
      <i class="fas fa-check"></i>
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
    <button class="button is-fullwidth has-background-primary	">
      Login
    </button>
  </p>
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
