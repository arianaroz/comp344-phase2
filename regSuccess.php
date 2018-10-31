<?php
include_once("config.php");

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $store_name ?> | Success</title>
<link rel="stylesheet" type="text/css" href="style1.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

</head>

<body>
<?php include("header.php"); ?>
<section class="hero has-background-white-bis is-medium">
    <div class="hero-body">
        <div class="regSuccess has-background-white">
             <div class="card-content">
            <h5 class="title is-4">Registration Successful</h5>

             <div class="is-size-6"> Thank you for registering to the Super Notebook Store.</div>
             <div  class="is-size-6"> Please check your email for your account information. </div>
        <div>
    <button class="button is-link  has-background-primary" id="rl" type="submit" name="login" onclick="location.href = 'signin.php';">Login to your account</button>
    </div>
<div class="field ">
    <div class="is-size-7" id="link">Or return to <a id="registerlink" href="index.php">homepage</a></div>
</div>
</div>
</div>


</section

<div class="footer">
<?php include("footer.php"); ?>
</div>
</body>
</html>
