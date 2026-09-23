<?php
// Start the session to access session variables
session_start();

// Turn off error reporting (not recommended for development)
error_reporting(0);

// Include the configuration file that likely contains database connection details
include('includes/config.php');

// Check if the user is logged in by verifying session variable
if(strlen($_SESSION['login'])==0) {    
    // Redirect to index page if not logged in
    header('location:index.php');
}
else {
    // Check if the form was submitted with the 'submit6' button
    if(isset($_POST['submit6'])) {
        // Get form data
        $name = $_POST['name'];
        $mobileno = $_POST['mobileno'];
        $email = $_SESSION['login']; // Get email from session

        // SQL query to update user profile
        $sql = "update tblusers set FullName=:name, MobileNumber=:mobileno where EmailId=:email";
        
        // Prepare the SQL statement to prevent SQL injection
        $query = $dbh->prepare($sql);
        
        // Bind parameters to the prepared statement
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        
        // Execute the query
        $query->execute();
        
        // Set success message
        $msg = "Profile Updated Successfully";
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Lamu | Tourism Management System</title>
    <!-- Meta tags for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Tourism Management System In PHP" />
    
    <!-- JavaScript to hide URL bar on mobile devices -->
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
    <link href="css/font-awesome.css" rel="stylesheet">
    
    <!-- Custom Theme files -->
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Animate.css for animations -->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init(); // Initialize WOW.js for animations
    </script>

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
<!-- top-header -->
<div class="top-header">
    <?php include('includes/header.php'); // Include header file ?>
    
    <div class="banner-1 ">
        <div class="container">
            <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
                Lamu -Tourism Management System
            </h1>
        </div>
    </div>
</div>
<!--- /banner-1 ---->

<!--- privacy ---->
<div class="privacy">
    <div class="container">
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
            My Profile!!
        </h3>
        
        <!-- Profile update form -->
        <form name="chngpwd" method="post">
            <!-- Display error/success messages -->
            <?php if($error){ ?>
                <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
            <?php } else if($msg){ ?>
                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
            <?php } ?>

            <?php 
            // Get user email from session
            $useremail = $_SESSION['login'];
            
            // SQL query to fetch user details
            $sql = "SELECT * from tblusers where EmailId=:useremail";
            $query = $dbh->prepare($sql);
            $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
            $query->execute();
            
            // Fetch results as objects
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = 1;
            
            // Check if user exists
            if($query->rowCount() > 0) {
                foreach($results as $result) { 
            ?>
                    <!-- Display user information in form fields -->
                    <p style="width: 350px;">
                        <b>Name</b>  
                        <input type="text" name="name" value="<?php echo htmlentities($result->FullName);?>" class="form-control" id="name" required>
                    </p> 

                    <p style="width: 350px;">
                        <b>Mobile Number</b>
                        <input type="text" class="form-control" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->MobileNumber);?>" id="mobileno" required>
                    </p>

                    <p style="width: 350px;">
                        <b>Email Id</b>
                        <input type="email" class="form-control" name="email" value="<?php echo htmlentities($result->EmailId);?>" id="email" readonly>
                    </p>
                    
                    <p style="width: 350px;">
                        <b>Last Updation Date : </b>
                        <?php echo htmlentities($result->UpdationDate);?>
                    </p>

                    <p style="width: 350px;">	
                        <b>Reg Date :</b>
                        <?php echo htmlentities($result->RegDate);?>
                    </p>
            <?php 
                } 
            } 
            ?>

            <p style="width: 350px;">
                <!-- Update button -->
                <button type="submit" name="submit6" class="btn-primary btn">Update</button>
            </p>
        </form>
    </div>
</div>
<!--- /privacy ---->

<!--- footer-top ---->
<?php include('includes/footer.php'); // Include footer ?>

<!-- signup modal -->
<?php include('includes/signup.php'); ?>			

<!-- signin modal -->
<?php include('includes/signin.php'); ?>			

<!-- write us modal -->
<?php include('includes/write-us.php'); ?>

</body>
</html>
<?php } // Close the else block ?>