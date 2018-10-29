<?php

// Regular Expression for form validation
function username_validation($text){
  $re = "/^[A-Za-z\S]+$/";

  if (strlen($text)<4 || strlen($text)>120){
    echo "
    <div class='regi_error'>
    Please enter a valid username
    </div>
    ";
    return false;
  }

  else if (preg_match($re, $text)==false){
    echo "
    <div class='regi_error'>
    Please enter a valid username
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
    Please enter a valid email address
    </div>
    ";
    return false;
  }
  else {
    return true;
  }

}

function password_validation($text){
  $re = "/^[A-Za-z]+[0-9]+[A-Za-z0-9]*$/";

  if (strlen($text)<8 || strlen($text)>30){
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

function phone_validation($text){
  $re = "/^\d+$/";

  if (strlen($text)<8 || strlen($text)>15){
    echo "
    <div class='regi_error'>
    Please enter a valid phone number
    </div>
    ";
    return false;
  }

  else if (preg_match($re, $text)==false){
    echo "
    <div class='regi_error'>
    Please enter valid a phone number
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
        echo "
        <div class='regi_error'>
        Passwords do not match.
        </div>
        ";
        return false;
    }
    else{
        return true;
    }
}

?>
