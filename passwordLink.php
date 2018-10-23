<?php

include("db.php");
require_once("./session.php");


$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

?>
