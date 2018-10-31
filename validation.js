
function validate_registration(){
  // Username validation
  var re = /^[A-Za-z\S]+$/;
  var text = document.getElementById('username').value;

  if (text.length<4 || text.length>120){
    window.alert('Please enter a valid username');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Please enter a valid username');
    return false;
  }

  // Email validation
  re = /^[a-zA-Z0-9_\.-]+\w@\w+\.\w+[a-zA-Z0-9_\.-]*$/;

  text = document.getElementById('email').value;

  if (re.test(text)==false){
  alert('Please provide a valid email address');
      return false;
  }

  // Password validation
  re = /^[A-Za-z]+[0-9]+[A-Za-z0-9]*$/;
  text = document.getElementById('password').value;
  text2 = document.getElementById('confirmPassword').value;

  if (text.length<8){
    window.alert('Password must be at least 8 characters');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Password must start with a character and contain at least one number.');
    return false;
  }

  // Password match check
  if (text != text2){
    window.alert("Passwords do not match");
    return false;
  }

  // Phone validation
  re = /^\d+$/;
  text = document.getElementById('phone').value;

  if (text.length<8){
    window.alert('Phonr number must be at least 8 digits');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Please enter a valid phone number.');
    return false;
  }

}

function validate_reset(){
  // Password validation
  re = /^[A-Za-z]+[0-9]+[A-Za-z0-9]*$/;
  text = document.getElementById('password').value;
  text2 = document.getElementById('confirmPassword').value;

  if (text.length<8){
    window.alert('Password must be at least 8 characters');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Password must start with a character and contain at least one number.');
    return false;
  }

  // Password match check
  if (text != text2){
    window.alert("Passwords do not match");
    return false;
  }

}

function validate_login(){
  // Username validation
  var re = /^[A-Za-z\S]+$/;
  var text = document.getElementById('username').value;

  if (text.length<4 || text.length>120){
    window.alert('Please enter a valid username');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Please enter a valid username');
    return false;
  }

  // Email validation
  re = /^[a-zA-Z0-9_\.-]+\w@\w+\.\w+[a-zA-Z0-9_\.-]*$/;

  text = document.getElementById('email').value;

  if (re.test(text)==false){
  alert('Please provide a valid email address');
      return false;
  }

  // Password validation
  re = /^[A-Za-z]+[0-9]+[A-Za-z0-9]*$/;
  text = document.getElementById('password').value;
  text2 = document.getElementById('confirmPassword').value;

  if (text.length<8){
    window.alert('Password must be at least 8 characters');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Password must start with a character and contain at least one number.');
    return false;
  }

}


function emailValidate(){
    re = /^[a-zA-Z0-9_\.-]+\w*@\w+\.\w+[a-zA-Z0-9_\.-]*$/;
    text = document.getElementById('email').value;
    if (re.test(text)==false){
    alert('Please provide a valid email address');
        return false;
}
}


function validate_login(){
  // Username validation
  var re = /^[A-Za-z\S]+$/;
  var text = document.getElementById('username').value;

  if (text.length<4 || text.length>120){
    window.alert('Please enter a valid username');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Please enter a valid username');
    return false;
  }


  // Password validation
  re = /^[A-Za-z]+[0-9]+[A-Za-z0-9]*$/;
  text = document.getElementById('password').value;

  if (text.length<8){
    window.alert('Password must be at least 8 characters');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Password must start with a character and contain at least one number.');
    return false;
  }

  }
