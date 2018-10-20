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
<link rel="stylesheet" href="style1.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
</head>
<body>
<script type="text/javascript">

</script>
<section class="hero has-background-white-bis is-medium">
<div class="hero-body">
        <div class="loginContainer">

        <form class="signin" method="POST">
            <h5 class="title is-5">Sign In</h5>
            <div class="error"><?php echo $error;?></div>
            <input type="text" name="username" class="login-form" placeholder="Username" required>
        <div>
            <input type="password" name="password" id="inputPassword" class="login-form" placeholder="Password" required>
            <div> <button id="login-btn" class="button" type="submit" name="login">Sign In</button> </div>
            <div id="passlink"> <a id="passwordlink" href=""> Forgot your password? </a> </div>
            <div id="link">Don't have an account? <a id="registerlink" href="register.php">Sign Up</a></div>
        </div>
    </form>
</div>
</div>
</section>
<div class="footer">
<?php include("footer.php"); ?>
</div>

</body>
</html>
