<?php
// Start PHP session to manage user state
session_start();

// Disable error reporting (not recommended for development)
error_reporting(0);

// Include database configuration file
include('includes/config.php');

// Check if user is logged in by verifying session variable
if(strlen($_SESSION['login'])==0)
{    
    // Redirect to index page if not logged in
    header('location:index.php');
}
else{
?>
<!DOCTYPE HTML>
<html>
<head>
<!---- <title>Lamu | Tourism Management System</title>
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
    <!-- Include header file -->
    <?php include('includes/header.php');?>
    
    <!-- Banner section -->
    <div class="banner-1 ">
        <div class="container">
            <!-- Animated heading -->
            <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
                Lamu Coolsprings-Tourism Management System
            </h1>
        </div>
    </div>
</div>

<!-- Main content section -->
<div class="privacy">
    <div class="container">
        <!-- Section heading with animation -->
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
            Issue Tickets
        </h3>
        
        <!-- Form for displaying tickets (note: no actual form submission here) -->
        <form name="chngpwd" method="post" onSubmit="return valid();">
            <!-- Display error message if exists -->
            <?php if($error){ ?>
                <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
            <?php } 
            // Display success message if exists
            else if($msg){ ?>
                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
            <?php } ?>
            
            <!-- Tickets table -->
            <p>
                <table border="1" width="100%">
                    <tr align="center">
                        <th>#</th>
                        <th>Ticket Id</th>
                        <th>Issue</th>    
                        <th>Description</th>
                        <th>Admin Remark</th>
                        <th>Reg Date</th>
                        <th>Remark date</th>
                    </tr>
                    <?php 
                    // Get user email from session
                    $uemail = $_SESSION['login'];
                    
                    // SQL query to fetch user's tickets
                    $sql = "SELECT * from tblissues where UserEmail=:uemail";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':uemail', $uemail, PDO::PARAM_STR);
                    $query->execute();
                    
                    // Fetch results as objects
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    
                    // Check if tickets exist
                    if($query->rowCount() > 0)
                    {
                        // Loop through each ticket
                        foreach($results as $result)
                        {    
                    ?>
                            <tr align="center">
                                <td><?php echo htmlentities($cnt);?></td>
                                <td width="100">#TKT-<?php echo htmlentities($result->id);?></td>
                                <td><?php echo htmlentities($result->Issue);?></td>
                                <td width="300"><?php echo htmlentities($result->Description);?></td>
                                <td><?php echo htmlentities($result->AdminRemark);?></td>
                                <td width="100"><?php echo htmlentities($result->PostingDate);?></td>
                                <td width="100"><?php echo htmlentities($result->AdminremarkDate);?></td>
                            </tr>
                    <?php 
                            $cnt = $cnt + 1; 
                        } 
                    } 
                    ?>
                </table>
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
<?php } // Closing brace for the else statement ?>