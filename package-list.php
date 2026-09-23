<?php
// Start a PHP session to manage user state across pages
session_start();

// Disable error reporting for production (errors won't be displayed)
error_reporting(0);

// Include the database configuration file
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu | Package List</title>
<!-- Meta tags for responsive design -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
<!--//end-animate-->
</head>
<body>
<!-- Include header section -->
<?php include('includes/header.php');?>

<!--- banner ---->
<div class="banner-3">
    <div class="container">
        <!-- Animated heading with zoom effect -->
        <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Lamu - Package List</h1>
    </div>
</div>
<!--- /banner ---->

<!--- rooms ---->
<div class="rooms">
    <div class="container">
        <div class="room-bottom">
            <h3>Our Accomodation List</h3>

            <?php 
            // SQL query to fetch all tour packages from the database
            $sql = "SELECT * from tbltourpackages";
            $query = $dbh->prepare($sql); // Prepare the SQL statement
            $query->execute(); // Execute the query
            $results = $query->fetchAll(PDO::FETCH_OBJ); // Fetch results as objects
            $cnt = 1; // Counter variable

            // Check if there are any results
            if($query->rowCount() > 0) {
                // Loop through each package result
                foreach($results as $result) { 
            ?>
            <div class="rom-btm">
                <!-- Left column: Package image with fade-in animation -->
                <div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                    <img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
                </div>

                <!-- Middle column: Package details with fade-in animation -->
                <div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
                    <h4>Package Name: <?php echo htmlentities($result->PackageName);?></h4>
                    <h6>Package Type : <?php echo htmlentities($result->PackageType);?></h6>
                    <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation);?></p>
                    <p><b>Features</b> <?php echo htmlentities($result->PackageFetures);?></p>
                    <p><b>Rooms Available:</b> <?php echo htmlentities($result->rooms);?></p>
                </div>

                <!-- Right column: Package price and details link with fade-in animation -->
                <div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
                    <h5>KSH <?php echo htmlentities($result->PackagePrice);?></h5>
                    <!-- Link to package details page with PackageId as a GET parameter -->
                    <a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId);?>" class="view">Details</a>
                </div>

                <!-- Embedded Google Map showing Lamu -->
                <iframe
                    width="150"
                    height="150"
                    frameborder="0" style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDBUF07ACyYIrOCYefRgj6YrMJ6R0rCcl4&q=Lamu" allowfullscreen>
                </iframe>

                <div class="clearfix"></div> <!-- Clear floating elements -->
            </div>
            <?php 
                } // End of foreach loop
            } // End of if condition
            ?>
        </div>
    </div>
</div>
<!--- /rooms ---->

<!--- /footer-top ---->
<?php include('includes/footer.php');?> <!-- Include footer section -->

<!-- Include modal popups -->
<?php include('includes/signup.php');?> <!-- Signup modal -->         
<?php include('includes/signin.php');?> <!-- Signin modal -->          
<?php include('includes/write-us.php');?> <!-- Contact us modal -->            
</body>
</html>