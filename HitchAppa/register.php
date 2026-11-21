<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
    <script>
        function emailValidator(){
            var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            var email_name=document.getElementById("email");

            if(email.value.match(emailExp)){
                document.getElementById('email_err').innerHTML='Valid email format';
                document.getElementById('email_err').style.color="#00AF33";
                return true;
            }else{
                document.getElementById('email_err').innerHTML='This is not a valid email format.';
                email_name.focus();
                document.getElementById('email_err').style.color="#FF0000";
                return false;
            }
    }
    </script>
</head>
<body>
      <div class="container">
        <div class="box form-box">

        <?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $age = (int) ($_POST['age'] ?? 0);
            $password = $_POST['password'] ?? '';

         //verifying the unique email
         $verify = $conn->prepare("SELECT 1 FROM users WHERE email = ?");
         $verify->bind_param("s", $email);
         $verify->execute();
         $verify->store_result();

         if(!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8){
            echo "<div class='message'>
                      <p>Please enter a valid email and a password of at least 8 characters.</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         elseif($verify->num_rows != 0){
            echo "<div class='message'>
                      <p>This email is used, Try another One Please!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         else{

            // Store a bcrypt hash, never the plain password
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (username, password, age, email) VALUES (?, ?, ?, ?)");
            $insert->bind_param("ssis", $username, $hash, $age, $email);
            $insert->execute();

            echo "<div class='message'>
                      <p>Registration successful!</p>
                  </div> <br>";
            echo "<a href='index.php'><button class='btn'>Login Now</button>";
         

         }

         }else{
         
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" onblur="emailValidator()" required><span id="email_err"></span>
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