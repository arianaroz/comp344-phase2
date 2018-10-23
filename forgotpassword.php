<?php
include("db.php");
$error= "";




?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
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
        <form action="" method="POST" id="form">
                    <p class="control has-icons-left ">
                    <input class="input" id="email" type="email" name="email" placeholder="Email" required>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </p>
            </div>

        <div class="field">
            <p class="control">
                <button class="button is-fullwidth has-background-primary"  onclick="return emailValidate();" type="submit" name"submit">Submit</button>
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

<?php

if(isset($_POST['submit'])){
    echo"hello";
}

?>




<div class="footer">
<?php include("footer.php"); ?>
</div>

</body>
</html>
