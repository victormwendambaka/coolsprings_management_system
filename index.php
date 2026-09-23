<?php
// Start PHP session to manage user state
session_start();

// Disable error reporting (not recommended for development)
error_reporting(0);

// Include database configuration file
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu | Tourism Management System</title>
<!-- Responsive viewport settings -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Character encoding -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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

<!-- Font Awesome CSS -->
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
</head>
<body>
<!-- Include header navigation -->
<?php include('includes/header.php');?>

<!-- Banner section -->
<div class="banner">
    <div class="container">
        <!-- Commented out banner heading -->
        <!-- <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;" style="color:#000 !important"> Lamu - Tourism Management System</h1> -->
    </div>
</div>

<!-- Package listing section -->
<div class="container">
    <div class="holiday">
        <h3>Package List</h3>
        
        <?php 
        // SQL query to fetch 4 random tour packages
        $sql = "SELECT * from tbltourpackages order by rand() limit 4";
        
        // Prepare and execute the query
        $query = $dbh->prepare($sql);
        $query->execute();
        
        // Fetch results as objects
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        
        // Check if packages were found
        if($query->rowCount() > 0)
        {
            // Loop through each package result
            foreach($results as $result)
            {	
        ?>
                <!-- Package listing item -->
                <div class="rom-btm">
                    <!-- Package image -->
                    <div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                        <img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
                    </div>
                    
                    <!-- Package details -->
                    <div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
                        <h4>Package Name: <?php echo htmlentities($result->PackageName);?></h4>
                        <h6>Package Type : <?php echo htmlentities($result->PackageType);?></h6>
                        <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation);?></p>
                        <p><b>Features</b> <?php echo htmlentities($result->PackageFetures);?></p>
                        
                        <!-- Star rating system -->
                        <div class="rating">
                            <style>
                                .star {
                                    color: gold; /* Gold star color */
                                    font-size: 24px; /* Larger star size */
                                }
                            </style>
                            <input type="hidden" class="package_id" value="<?php echo htmlentities($result->PackageId);?>">
                            <span class="star" data-rating="1">&#9733;</span>
                            <span class="star" data-rating="2">&#9733;</span>
                            <span class="star" data-rating="3">&#9733;</span>
                            <span class="star" data-rating="4">&#9733;</span>
                            <span class="star" data-rating="5">&#9733;</span>
                        </div>
                    </div>
                    
                    <!-- Package price and details link -->
                    <div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
                        <h5>KSH <?php echo htmlentities($result->PackagePrice);?></h5>
                        <a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId);?>" class="view">Details</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
        <?php 
            } 
        } 
        ?>
        
        <!-- View more packages link -->
        <div><a href="package-list.php" class="view">View More Packages</a></div>
    </div>
    
    <!-- Google Maps embed -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11616.56379916231!2d40.89229684944432!3d-2.265264080408875!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1817193fab651595%3A0x7dd791cc38ba2835!2sLamu%2C%20Kenya!5e0!3m2!1sen!2sus!4v1711459293819!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <div class="clearfix"></div>
</div>

<!-- Statistics section -->
<div class="routes">
    <div class="container">
        <!-- Packages count -->
        <div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".5s">
            <div class="rou-left">
                <a href="#"><i class="glyphicon glyphicon-list-alt"></i></a>
            </div>
            <div class="rou-rgt wow fadeInDown animated" data-wow-delay=".5s">
                <?php 
                // Query to count total tour packages
                $sql = "SELECT COUNT(*) AS totalInquiries FROM tbltourpackages";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $totalInquiries = $result['totalInquiries'];
                ?>
                <h3><?php echo $totalInquiries; ?></h3>
                <p>Packages</p>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <!-- Registered users count -->
        <div class="col-md-4 routes-left">
            <div class="rou-left">
                <a href="#"><i class="fa fa-user"></i></a>
            </div>
            <div class="rou-rgt">
                <?php 
                // Query to count total registered users
                $sql = "SELECT COUNT(*) AS totalUsers FROM tblusers";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $totalUsers = $result['totalUsers'];
                ?>
                <h3><?php echo $totalUsers; ?></h3>
                <p>Registered users</p>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <!-- Bookings count -->
        <div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".5s">
            <div class="rou-left">
                <a href="#"><i class="fa fa-ticket"></i></a>
            </div>
            <div class="rou-rgt">
                <?php
                // Query to count total bookings
                $sql = "SELECT COUNT(*) AS totalBookings FROM tblbooking";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $totalBookings = $result['totalBookings'];
                ?>
                <h3><?php echo $totalBookings; ?></h3>
                <p>Booking</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Footer and modal includes -->
<?php include('includes/footer.php');?>
<?php include('includes/signup.php');?>    <!-- Signup modal -->
<?php include('includes/signin.php');?>    <!-- Signin modal -->
<?php include('includes/write-us.php');?>  <!-- Contact modal -->
</body>
</html>