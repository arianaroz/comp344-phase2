<?php
//include("common_db.php");
//include("db.php");


// Regular Expression for form validation
function name_validation($text){
  $re = "/^[A-Za-z\s\']+$/";

  if (strlen($text)<1 || strlen($text)>120){
    echo "
    <div class='regi_error'>
    Please enter a valid name
    </div>
    ";
    return false;
  }

  else if (preg_match($re, $text)==false){
    echo "
    <div class='regi_error'>
    Please enter a valid name
    </div>
    ";
    return false;
  }
  else {
    return true;
  }
}

function email_validation($text){
  $re = "/^[a-zA-Z0-9_\.-]+\w@\w+\.\w+[a-zA-Z0-9_\.-]*$/";

  if (preg_match($re, $text)==false){
    echo "
    <div class='regi_error'>
    Please enter a valid MQ email address
    </div>
    ";
    return false;
  }
  else {
    return true;
  }

}

function password_validation($text){
  $re = "/^[A-Za-z]+[0-9]+[A-Za-z]*[0-9]*$/";

  if (strlen($text)<6 || strlen($text)>10){
    echo "
    <div class='regi_error'>
    Please enter a valid password
    </div>
    ";
    return false;
  }


  if (preg_match($re, $text)==false){
    echo "
    <div class='regi_error'>
    Please enter a valid password
    </div>
    ";
    return false;
  }
  else {
    return true;
  }

}

function passwordCheck($pass1, $pass2){
    global $error;
    if ($pass1 != $pass2){
        $error = "Passwords do not match.";
        /*echo "
        <div class='regi_error'>
        Passwords do not match.
        </div>
        ";*/
        return false;
    }
    else{
        return true;
    }
}

?>
