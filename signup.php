<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign-Up Page</title>
  <link rel="stylesheet" href="stylesheet.css">
  <script src="validation.js"></script>
</head>

<body style="background-image: url('http://codd.cs.gsu.edu/~gganapathiappan1/WP/PW/Final/background.jpg');">
  <div class="logo">
    <img src="Property-Hub-logos_transparent.png" alt="logo">
  </div>
  <div class="form-container">
    <div class="header">
      <h1>Sign up</h1>
      <p>Please fill in this form to create an account</p>
    </div>
    <hr>
    <form id="signup-form" action="handle_signup.php" method="post" onsubmit="return validateForm()">
    <div class="form-box">
      <small> 
        <?php if(isset($usernameErr)) { echo $usernameErr;} ?>
        <?php if(isset($passwordErr)) { echo $passwordErr;} ?>
        <?php if(isset($emailErr)) { echo $emailErr;} ?>
     </small>
     <small></small>
    </div>
      <div class="form-box">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="username" required>
        <small> <span id="usernameErr"></span> </small>
      </div>
      <div class="form-box">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" placeholder="email" required>
        <small> <span id="emailErr"></span> </small>
      </div>
      <div class="form-box">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="password" required>
         <small><span id="passwordErr"></span></small> 
      </div>
      <div class="form-box">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="confirm password" required>
        <small> <span id="confirmPassErr"></span> </small>
      </div>
      <div class="form-box">
        <label for="user_type">Are you a:</label>
        <select name="type" id="type" required>
          <option value="buyer">Buyer</option>
          <option value="seller">Seller</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="form-box">
        <input class="submit" type="submit" value="Sign up" name="signup">
      </div>
      <div class="form-box">
        <p>Already have an account <a href="login.php">Log In</a></p>
      </div>
    </form>
  </div>
</body>

</html>