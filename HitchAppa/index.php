<?php 
   session_start();
    // Remember the last-used email for 30 days (HttpOnly so scripts can't read it)
    $email = $_POST['email'] ?? null;

    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie("email", $email, ['expires' => time() + 86400 * 30, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
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
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                // Prepared statement: user input never becomes part of the SQL text
                $stmt = $conn->prepare("SELECT id, username, email, age, password FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $row = $stmt->get_result()->fetch_assoc();

                if($row && password_verify($password, $row['password'])){
                    session_regenerate_id(true); // prevent session fixation
                    $_SESSION['valid'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['age'] = $row['age'];
                    $_SESSION['id'] = $row['id'];
                }else{
                    echo "<div class='message'>
                      <p>Wrong Username or Password</p>
                       </div> <br>";
                   echo "<a href='index.php'><button class='btn'>Go Back</button>";
         
                }
                if(isset($_SESSION['valid'])){
                    header("Location: home.php");
                    exit;
                }
              }else{

            
            ?>
            <header>HitchApp Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" onblur="emailValidator()" required><span id="email_err"></span>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account yet? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>