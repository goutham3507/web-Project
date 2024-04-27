function validateForm() {
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const confirmPassword = document.getElementById("confirmPassword").value.trim();
  var isValid = true;

  if (username.length < 5 || username.length > 10) {
    isValid = false;
    document.getElementById('usernameErr').innerText = 'Username must between 5 and 10 character.';
  } else {
    document.getElementById('usernameErr').innerText = '';
  }

  if (!isEmail(email)) {
    isValid = false;
    document.getElementById('emailErr').innerText = 'Please enter a valid email address.';
  } else {
    document.getElementById('emailErr').innerText = '';
  }

  if (password.length < 5 || password.length > 10) {
    isValid = false;
    document.getElementById("passwordErr").innerHTML = 'Password must between 5 and 10 characters';
  } else if(password === username) {
    isValid = false;
    document.getElementById("passwordErr").innerHTML = 'Password must not same as username.'
  } 
  else {
    document.getElementById("passwordErr").innerHTML = '';
  }

  if (confirmPassword !== password) {
    isValid = false;
    document.getElementById("confirmPassErr").innerHTML = 'Password do not match';
  } else {
    document.getElementById("confirmPassErr").innerHTML = '';
  }
  if (!isValid) {
    event.preventDefault();
  }
  return isValid;
}
function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{3,}))$/.test(email);
}

 