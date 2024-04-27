<?php
session_start();
include("connectToDB.php");


if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $sql = "SELECT * FROM users WHERE user_name = '$username'";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
  if ($user) {
    if (password_verify($password, $user["user_password"])) {
      setcookie("user_id", $user["user_id"], time()+60*60*24*30);
      setcookie("username", $username, time()+60*60*12);
      if (isset($_POST["remember"])) {
        setcookie("user_name", $username, time() + 30);
        setcookie(("user_password"), $password, time() + 30);
      } else {
        if (isset($_COOKIE["user_name"])) {
          setcookie("user_name", "");
        }
        if (isset($_COOKIE["user_password"])) {
          setcookie("user_password", "");
        }
      }
      $_SESSION["username"] = $username;
      header("Location: dashboard.php");
      die();
    } else {
      $passwordErr = "<p>Please enter password correctly.</p>";
    }
  } else {
    $usernameErr = "<p> Please enter username correctly.</p>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>

<body style="background-image: url('http://codd.cs.gsu.edu/~gganapathiappan1/WP/PW/Final/background.jpg');">
  <div class="logo">
    <img src="Property-Hub-logos_transparent.png" alt="logo">
  </div>
  <div class="form-container">
    <div class="header">
      <h1>Log In</h1>
      <p>Please enter your username and password to log in</p>
    </div>
    <hr>
    <form action="" method="post">
      <div class="form-box">
        <small></small>
      </div>
      <div class="form-box">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="username" value="<?php if (isset($_COOKIE["user_name"])) {
                                                                                          echo $_COOKIE["user_name"];
                                                                                        } ?>" required>
        <small><?php if (isset($usernameErr)) {
                  echo $usernameErr;
                } ?></small>
      </div>
      <div class="form-box">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="password" value="<?php if (isset($_COOKIE["user_password"])) {
                                                                                              echo $_COOKIE["user_password"];
                                                                                            } ?>" required>
        <small><?php if (isset($passwordErr)) {
                  echo $passwordErr;
                } ?></small>
      </div>
      <div class="remember">
      <input type="checkbox" name="remember" id="remember" <?php if (isset($_COOKIE["user_name"])) { ?> checked <?php } ?> >
        <label for="remember">Remember Me</label>
      </div>
        <div class="form-box">
          <input type="submit" id="submit" name="login" value="Log in">
        </div>
        <div class="form-box">
          <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </form>
  </div>
</body>

</html>