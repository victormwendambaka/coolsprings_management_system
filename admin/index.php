<?php
// Start session for user authentication
session_start();
// Include database configuration
include('includes/config.php');

// Check if login form was submitted
if(isset($_POST['login'])) {
    $uname = $_POST['username'];
    $password = md5($_POST['password']); // Using MD5 for password hashing (not recommended)
    
    // SQL query to check admin credentials
    $sql = "SELECT UserName,Password FROM admin WHERE UserName=:uname and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    // If matching admin found
    if($query->rowCount() > 0) {
        $_SESSION['alogin'] = $_POST['username']; // Set session variable
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>"; // Redirect to dashboard
    } else {
        echo "<script>alert('Invalid Details');</script>"; // Show error message
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Coolsprings | Admin Sign in</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Mobile viewport optimization -->
<script type="application/x-javascript"> 
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
    function hideURLbar(){ window.scrollTo(0,1); } 
</script>

<!-- CSS includes -->
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.css"> 
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>

<!-- Google Fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- Icon fonts -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
</head> 
<body>
    <div class="main-wthree">
        <div class="container">
            <div class="sin-w3-agile">
                <h2>Admin Login</h2>
                <form method="post">
                    <!-- Username field -->
                    <div class="username">
                        <span class="username">Username:</span>
                        <input type="text" name="username" class="name" placeholder="" required>
                        <div class="clearfix"></div>
                    </div>
                    
                    <!-- Password field -->
                    <div class="password-agileits">
                        <span class="username">Password:</span>
                        <input type="password" name="password" class="password" placeholder="" required>
                        <div>
                            <br>
                            <a href="forgot-password.php" style="color: #fff;">Forgot Password</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <!-- Submit button -->
                    <div class="login-w3">
                        <input type="submit" class="login" name="login" value="Sign In">
                    </div>
                    <div class="clearfix"></div>
                </form>
                
                <!-- Back to home link -->
                <div class="back">
                    <a href="../index.php" style="color: #fff;">Back to home</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>