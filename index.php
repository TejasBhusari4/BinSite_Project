<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">
            <?php 
             
              include("php/config.php");
              if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                // Server-side validation for email format
                $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/";

                // Validate the email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match($emailPattern, $email)) {
                    echo "<div class='message'>
                              <p>Invalid email format. Please enter a valid email!</p>
                          </div><br>";
                    echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
                } else {
                    // Query to check if the user exists
                    $result = mysqli_query($con, "SELECT * FROM users WHERE Email='$email' AND Password='$password'") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);

                    if (is_array($row) && !empty($row)) {
                        // Set session variables
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['username'] = $row['Username'];
                        // $_SESSION['age'] = $row['Age'];
                        $_SESSION['id'] = $row['Id'];

                        // Redirect to the specified URL after successful login
                        header("Location: http://127.0.0.1:5501/log_out/project_BinSite/index.html");
                        exit(); // Make sure to exit after header redirection
                    } else {
                        // Display error message if login fails
                        echo "<div class='message'>
                                <p>Wrong Username or Password</p>
                              </div><br>";
                        echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
                    }
                }
              } else {
                  // If the form is not yet submitted, display the form
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <!-- The form submission will trigger the PHP block above -->
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Don't have account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>

