function validate(){
  // Username validation
  var re = /^[A-Za-z\S]+$/;
  var text = document.getElementById('name').value;

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
  text = document.getElementById('password').value;

  if (text.length<8){
    window.alert('Phonr number must be at least 8 digits');
    return false;
  }
  else if (re.test(text)==false){
    window.alert('Please enter a valid phone number.');
    return false;
  }
  
}


  // // Street No validation
  // re = /^\d+\/?\d+?$/;
  // text = document.getElementById('streetno').value;
  //
  // if (text.length<1 || text.length>10){
  //   window.alert('Please enter a valid Street No');
  //   return false;
  // }
  // else if (re.test(text)==false){
  //   window.alert('Please enter a valid Street No');
  //   return false;
  // }
  //
  // // Street Name validation
  // re = /^[A-Za-z\s\']+$/;
  // text = document.getElementById('streetname').value;
  //
  // if (text.length<1 || text.length>120){
  //   window.alert('Please enter a valid Street Name');
  //   return false;
  // }
  // else if (re.test(text)==false){
  //   window.alert('Please enter a valid Street Name');
  //   return false;
  // }
  //
  // // Suburb Name validation
  // re = /^[A-Za-z\s\']+$/;
  // text = document.getElementById('suburb').value;
  //
  // if (text.length<1 || text.length>120){
  //   window.alert('Please enter a valid Suburb/City');
  //   return false;
  // }
  // else if (re.test(text)==false){
  //   window.alert('Please enter a valid Suburb/City');
  //   return false;
  // }
  //
  // // State validation
  // text = document.getElementById('state').value;
  //
  // if (text.length<1 || text.length>30){
  //   window.alert('Please enter a valid State');
  //   return false;
  // }
  //
  // var states = ["New South Wales", "NSW", "Queensland", "QLD", "South Australia", "SA", "Tasmania", "TAS", "Victoria", "VIC", "Western Australia", "WA", "Australian Capital Territory", "ACT"];
  // var i=0;
  // var trig = true;
  // for (i; i<states.length; i++){
  //   if(states[i].toLowerCase()==text.toLowerCase()){
  //     trig = false;
  //     break;
  //   }
  // }
  // if (trig){
  //   window.alert('Please enter a valid State');
  //   return false;
  // }
  //
  // // Post Code validation
  // re = /^\d+$/;
  // text = document.getElementById('postcode').value;
  //
  // if (text.length != 4){
  //   window.alert('Please enter a valid Post Code');
  //   return false;
  // }
  // else if (re.test(text)==false){
  //   window.alert('Please enter a valid Post Code');
  //   return false;
  // }


function emailValidate(){
    re = /^[a-zA-Z0-9_\.-]+\w*@\w+\.\w+[a-zA-Z0-9_\.-]*$/;
    text = document.getElementById('email').value;
    if (re.test(text)==false){
    alert('Please provide a valid email address');
        return false;
}
}
