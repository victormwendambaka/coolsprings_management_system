<?php
// Start session to manage user state
session_start();

// Disable error reporting (not recommended for development)
error_reporting(0);

// Include database configuration file
include('includes/config.php');

// Check if password recovery form was submitted
if(isset($_POST['submit50']))
{
    // Get form data
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $newpassword = md5($_POST['newpassword']); // Hash new password with MD5 (note: MD5 is insecure)
    
    // SQL to verify email and mobile match
    $sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email and MobileNumber=:mobile";
    
    // Prepare SQL statement to prevent SQL injection
    $query = $dbh->prepare($sql);
    
    // Bind parameters to the prepared statement
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    
    // Execute the query
    $query->execute();
    
    // Fetch results as objects
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    // Check if matching user was found
    if($query->rowCount() > 0)
    {
        // SQL to update password
        $con = "update tblusers set Password=:newpassword where EmailId=:email and MobileNumber=:mobile";
        
        // Prepare the update statement
        $chngpwd1 = $dbh->prepare($con);
        
        // Bind parameters for the update
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        
        // Execute the update
        $chngpwd1->execute();
        
        // Set success message
        $msg = "Your Password succesfully changed";
    }
    else {
        // Set error message if credentials don't match
        $error = "Email id or Mobile no is invalid";    
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu | Tourism Management System</title>
<!-- Responsive viewport settings -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Character encoding -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- SEO keywords -->
<meta name="keywords" content="Tourism Management System In PHP" />
<!-- JavaScript to hide URL bar on mobile -->
<script type="applijewelleryion/x-javascript"> 
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
    function hideURLbar(){ window.scrollTo(0,1); } 
</script>
<!-- CSS files -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Google Fonts -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<!-- Font Awesome -->
<link href="css/font-awesome.css" rel="stylesheet">
<!-- JavaScript files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- Animation CSS -->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<!-- WOW.js animation library -->
<script src="js/wow.min.js"></script>
<script>
    // Initialize WOW.js animations
    new WOW().init();
</script>
<!-- Password validation script -->
<script type="text/javascript">
function valid()
{
    // Validate that new password matches confirmation
    if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value)
    {
        // Show alert if passwords don't match
        alert("New Password and Confirm Password Field do not match !!");
        // Focus on confirm password field
        document.chngpwd.confirmpassword.focus();
        // Prevent form submission
        return false;
    }
    // Allow form submission if validation passes
    return true;
}
</script>
<!-- CSS for message styling -->
<style>
    /* Error message styling */
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    /* Success message styling */
    .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
</style>
</head>
<body>
<!-- Header section -->
<div class="top-header">
    <!-- Include header navigation -->
    <?php include('includes/header.php');?>
    
    <!-- Banner section -->
    <div class="banner-1 ">
        <div class="container">
            <!-- Animated heading -->
            <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
                Lamu -Tourism Management System
            </h1>
        </div>
    </div>
</div>

<!-- Main content section -->
<div class="privacy">
    <div class="container">
        <!-- Section heading with animation -->
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
            Recover Password
        </h3>
        
        <!-- Password recovery form with client-side validation -->
        <form name="chngpwd" method="post" onSubmit="return valid();">
            <!-- Display error message if exists -->
            <?php if($error){ ?>
                <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
            <?php } 
            // Display success message if exists
            else if($msg){ ?>
                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
            <?php } ?>
            
            <!-- Email input field -->
            <p style="width: 350px;">
                <b>Email id</b>
                <input type="email" name="email" class="form-control" id="email" placeholder="Reg Email id" required="">
            </p> 

            <!-- Mobile number input field -->
            <p style="width: 350px;">
                <b>Mobile No</b>
                <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Reg Mobile no" required="">
            </p> 

            <!-- New password input field -->
            <p style="width: 350px;">
                <b>New Password</b>
                <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New Password" required="">
            </p>

            <!-- Confirm password input field -->
            <p style="width: 350px;">
                <b>Confirm Password</b>
                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confrim Password" required="">
            </p>

            <!-- Submit button -->
            <p style="width: 350px;">
                <button type="submit" name="submit50" class="btn-primary btn">Change</button>
            </p>
        </form>
    </div>
</div>

<!-- Footer section -->
<?php include('includes/footer.php');?>

<!-- Modal includes -->
<?php include('includes/signup.php');?>            <!-- Signup modal -->
<?php include('includes/signin.php');?>            <!-- Signin modal -->
<?php include('includes/write-us.php');?>          <!-- Contact modal -->

</body>
</html>