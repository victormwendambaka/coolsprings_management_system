<?php
// Start a PHP session to manage user state across pages
session_start();

// Disable error reporting for production (errors won't be displayed)
error_reporting(0);

// Include the database configuration file
include('includes/config.php');

// Check if the enquiry form has been submitted
if(isset($_POST['submit1']))
{
    // Retrieve form data using POST method
    $fname = $_POST['fname'];
    $email = $_POST['email'];    
    $mobile = $_POST['mobileno'];
    $subject = $_POST['subject'];    
    $description = $_POST['description'];
    
    // SQL query to insert enquiry data into database
    $sql = "INSERT INTO tblenquiry(FullName,EmailId,MobileNumber,Subject,Description) VALUES(:fname,:email,:mobile,:subject,:description)";
    
    // Prepare the SQL statement
    $query = $dbh->prepare($sql);
    
    // Bind parameters to prevent SQL injection
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':subject', $subject, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    
    // Execute the query
    $query->execute();
    
    // Get the last inserted ID
    $lastInsertId = $dbh->lastInsertId();
    
    // Check if insertion was successful
    if($lastInsertId)
    {
        $msg = "Enquiry Successfully submitted";
    }
    else 
    {
        $error = "Something went wrong. Please try again";
    }
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

<!-- JavaScript to hide address bar on mobile devices -->
<script type="applijewelleryion/x-javascript"> 
    addEventListener("load", function() { 
        setTimeout(hideURLbar, 0); 
    }, false); 
    function hideURLbar(){ 
        window.scrollTo(0,1); 
    } 
</script>

<!-- CSS Stylesheets -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />

<!-- Google Fonts -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

<!-- Font Awesome for icons -->
<link href="css/font-awesome.css" rel="stylesheet">

<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script> <!-- jQuery library -->
<script src="js/bootstrap.min.js"></script> <!-- Bootstrap JS -->

<!-- Animate.css for animations -->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script> <!-- WOW.js for scroll animations -->
<script>
    new WOW().init(); // Initialize WOW.js animations
</script>

<!-- Custom CSS for error/success messages -->
<style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
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
    <!-- Include header section -->
    <?php include('includes/header.php');?>
    
    <!-- Banner section with zoom animation -->
    <div class="banner-1 ">
        <div class="container">
            <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Lamu-Tourism Management System</h1>
        </div>
    </div>
</div>
<!--- /banner-1 ---->

<!--- privacy ---->
<div class="privacy">
    <div class="container">
        <?php 
        // Get page type from URL parameter
        $pagetype = $_GET['type'];
        
        // SQL query to fetch page content based on type
        $sql = "SELECT type, detail from tblpages where type=:pagetype";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        
        // Check if page content exists
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {        
        ?>
        <!-- Display page title with fade animation -->
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
            <?php echo $_GET['type'] ?>
        </h3>
        
        <!-- Display page content -->
        <p>
            <?php echo $result->detail; ?>
        </p> 
        <?php 
            } // End foreach
        } // End if
        ?>
    </div>
</div>
<!--- /privacy ---->

<!--- footer-top ---->
<!--- /footer-top ---->
<?php include('includes/footer.php');?> <!-- Include footer section -->

<!-- Include modal popups -->
<?php include('includes/signup.php');?> <!-- Signup modal -->            
<?php include('includes/signin.php');?> <!-- Signin modal -->            
<?php include('includes/write-us.php');?> <!-- Contact us modal -->
</body>
</html>