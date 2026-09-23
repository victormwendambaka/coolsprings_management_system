<?php
// Start PHP session
session_start();

// Disable error reporting (not recommended for development)
error_reporting(0);

// Include database configuration file
include('includes/config.php');

// Check if enquiry form was submitted
if(isset($_POST['submit1']))
{
    // Get form data from POST request
    $fname = $_POST['fname'];
    $email = $_POST['email'];    
    $mobile = $_POST['mobileno'];
    $subject = $_POST['subject'];    
    $description = $_POST['description'];
    
    // SQL query to insert enquiry data
    $sql = "INSERT INTO tblenquiry(FullName,EmailId,MobileNumber,Subject,Description) VALUES(:fname,:email,:mobile,:subject,:description)";
    
    // Prepare SQL statement to prevent SQL injection
    $query = $dbh->prepare($sql);
    
    // Bind parameters to the prepared statement
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':subject', $subject, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    
    // Execute the query
    $query->execute();
    
    // Get the ID of the last inserted record
    $lastInsertId = $dbh->lastInsertId();
    
    // Check if insertion was successful
    if($lastInsertId)
    {
        // Set success message
        $msg = "Enquiry Successfully submited";
    }
    else 
    {
        // Set error message
        $error = "Something went wrong. Please try again";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu | Tourism Management System</title>
<!-- Responsive viewport meta tag -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Character encoding meta tag -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- SEO keywords -->
<meta name="keywords" content="Tourism Management System In PHP" />
<!-- JavaScript to hide URL bar on mobile devices -->
<script type="applijewelleryion/x-javascript"> 
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
    function hideURLbar(){ window.scrollTo(0,1); } 
</script>
<!-- Bootstrap CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- Google Fonts -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<!-- Font Awesome CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<script src="js/jquery-1.12.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="js/bootstrap.min.js"></script>
<!-- Animate.css -->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<!-- WOW.js for animations -->
<script src="js/wow.min.js"></script>
<script>
    // Initialize WOW.js animations
    new WOW().init();
</script>
<!-- CSS for error/success messages -->
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
    .succWrap {
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
    <!-- Include header file -->
    <?php include('includes/header.php');?>
    
    <!-- Banner section -->
    <div class="banner-1">
        <div class="container">
            <!-- Animated heading -->
            <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
                Lamu-Tourism Management System
            </h1>
        </div>
    </div>
</div>

<!-- Main content section -->
<div class="privacy">
    <div class="container">
        <!-- Section heading with animation -->
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
            Enquiry Form Password
        </h3>
        
        <!-- Enquiry form -->
        <form name="enquiry" method="post">
            <!-- Display error message if exists -->
            <?php if($error){ ?>
                <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
            <?php } 
            // Display success message if exists
            else if($msg){ ?>
                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
            <?php } ?>
            
            <!-- Full Name input field -->
            <p style="width: 350px;">
                <b>Full name</b>
                <input type="text" name="fname" class="form-control" id="fname" placeholder="Full Name" required="">
            </p>
            
            <!-- Email input field -->
            <p style="width: 350px;">
                <b>Email</b>
                <input type="email" name="email" class="form-control" id="email" placeholder="Valid Email id" required="">
            </p>

            <!-- Mobile Number input field -->
            <p style="width: 350px;">
                <b>Mobile No</b>
                <input type="text" name="mobileno" class="form-control" id="mobileno" maxlength="10" placeholder="10 Digit mobile No" required="">
            </p>

            <!-- Subject input field -->
            <p style="width: 350px;">
                <b>Subject</b>
                <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" required="">
            </p>
            
            <!-- Description textarea -->
            <p style="width: 350px;">
                <b>Description</b>
                <textarea name="description" class="form-control" rows="6" cols="50" id="description" placeholder="Description" required=""></textarea> 
            </p>

            <!-- Submit button -->
            <p style="width: 350px;">
                <button type="submit" name="submit1" class="btn-primary btn">Submit</button>
            </p>
        </form>
    </div>
</div>

<!-- Footer section -->
<?php include('includes/footer.php');?>

<!-- Modal includes -->
<?php include('includes/signup.php');?>            <!-- Signup modal -->
<?php include('includes/signin.php');?>            <!-- Signin modal -->
<?php include('includes/write-us.php');?>           <!-- Contact modal -->

</body>
</html>