<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

         // Email and password validation logic in PHP
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             echo "<div class='message'>
                      <p>Invalid email format. Please use a valid email!</p>
                  </div> <br>";
             echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
             echo "<div class='message'>
                      <p>Password does not meet the requirements. Must contain at least 8 characters, one uppercase letter, one lowercase letter, one number, and one special character.</p>
                  </div> <br>";
             echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         } 
         else {

            // Verifying the unique email
            $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

            if(mysqli_num_rows($verify_query) !=0 ){
                echo "<div class='message'>
                          <p>This email is already in use. Try another one, please!</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            }
            else {
                // Insert user data into the database
                mysqli_query($con,"INSERT INTO users(Username,Email,Password) VALUES('$username','$email','$password')") or die("Error Occurred");

                echo "<div class='message'>
                          <p>Registration successful!</p>
                      </div> <br>";
                echo "<a href='index.php'><button class='btn'>Login Now</button>";
            }
         }

         } else {
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <!-- Using type="email" for HTML5 email validation -->
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <!-- Adding regex pattern for password validation -->
                    <input type="password" name="password" id="password" autocomplete="off" required
                    pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}">
                    <!-- Password hint to help the user -->
                    <small>Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).</small>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>