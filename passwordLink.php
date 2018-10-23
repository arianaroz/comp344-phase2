<?php

include("db.php");


$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);


?>
