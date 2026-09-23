<?php
// Start PHP session to manage user state
session_start();

// Disable error reporting (not recommended for development)
error_reporting(0);

// Include database configuration file
include('includes/config.php');

// Check if booking form was submitted
if(isset($_POST['submit2']))
{
    // Get package ID from URL and sanitize it
    $pid=intval($_GET['pkgid']);
    
    // Get user email from session
    $useremail=$_SESSION['login'];
    
    // Get form data
    $fromdate=$_POST['fromdate'];
    $todate=$_POST['todate'];
    $comment=$_POST['comment'];
    $roomsbooked=$_POST['rooms'];
    $status=0;
    
    // Fetch room availability from packages table
    $sql="select * from TblTourPackages where PackageId=:pid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $roomsAv=$result->rooms; // Get available rooms count
        }
    }

    // Insert booking into database (duplicate check - same as above)
    if(isset($_POST['submit2']))
    {
        $pid=intval($_GET['pkgid']);
        $useremail=$_SESSION['login'];
        $fromdate=$_POST['fromdate'];
        $todate=$_POST['todate'];
        $comment=$_POST['comment'];
        $roomsbooked=$_POST['rooms'];
        $totalprice1=$_POST['totalprice'];
        $status=0;
        
        // SQL to insert booking record
        $sql="INSERT INTO tblbooking(PackageId,UserEmail,FromDate,ToDate,Comment,status,roomsbooked,Totalprice) VALUES(:pid,:useremail,:fromdate,:todate,:comment,:status,:roomsbooked,:totalprice1)";
        $query = $dbh->prepare($sql);
        // Bind all parameters
        $query->bindParam(':pid',$pid,PDO::PARAM_STR);
        $query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
        $query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
        $query->bindParam(':todate',$todate,PDO::PARAM_STR);
        $query->bindParam(':comment',$comment,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->bindParam(':roomsbooked',$roomsbooked,PDO::PARAM_STR);
        $query->bindParam(':totalprice1',$totalprice1,PDO::PARAM_STR);
        $query->execute();
        
        // Get last inserted ID
        $lastInsertId = $dbh->lastInsertId();
        
        if($lastInsertId)
        {
            // Check room availability and update if successful
            if($roomsAv>0){
                if($roomsAv>$roomsbooked){
                    $newRoomsAv=$roomsAv-$roomsbooked;
                    // Update available rooms count
                    $con="update TblTourPackages set rooms=:rooms where PackageId=:pid";
                    $chgstatus = $dbh->prepare($con);
                    $chgstatus->bindParam(':rooms', $newRoomsAv, PDO::PARAM_STR);
                    $chgstatus->bindParam(':pid', $pid, PDO::PARAM_STR);
                    $chgstatus->execute();
                    $msg="Booked Successfully";
                    $paymentLink = '<a href="daraja/index.php">Proceed to Payment</a>';
                }
                else
                {
                    $error="Insufficient Rooms Kindly Select Btn 1 to $roomsAv rooms";
                }
            }
            else{
                $error="No rooms available for this package";
            }
        }
        else 
        {
            $error="Something went wrong. Please try again";
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title> Lamu TMS | Package Details</title>
<!-- Responsive meta tags -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<!-- Animate.css -->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<!-- WOW.js -->
<script src="js/wow.min.js"></script>
<!-- jQuery UI for datepicker -->
<link rel="stylesheet" href="css/jquery-ui.css" />
<script>
    // Initialize WOW.js animations
    new WOW().init();
</script>
<script src="js/jquery-ui.js"></script>
<script>
    // Initialize datepicker with no past dates allowed
    $(function() {
        $( "#datepicker,#datepicker1" ).datepicker({minDate:0});
    });
</script>
<!-- CSS for error/success messages -->
<style>
    .errorWrap {
        padding: 10px;
        font-size: 16px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .succWrap{
        padding: 10px;
        font-size: 16px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
</style>                
</head>
<body style="font-size:14px;">
<!-- Include header -->
<?php include('includes/header.php');?>

<!-- Banner section -->
<div class="banner-3">
    <div class="container">
        <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;"> Lamu - Package Details</h1>
    </div>
</div>

<!-- Main booking form section -->
<div class="selectroom">
    <div class="container">   
        <!-- Display error/success messages -->
        <?php if($error): ?>
            <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
        <?php elseif($msg): ?>
            <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
            <!-- Payment link with custom styling -->
            <style>
                .box-container {
                    border: 2px solid #000;
                    border-radius: 10px;
                    padding: 10px;
                    display: inline-block;
                    background-color: #FFD700;
                }
                .proceed-link {
                    font-size: 20px;
                    text-decoration: none;
                    color:#FA3308;
                }
            </style>
            <div class="box-container">
                <a href="daraja/index.php" class="proceed-link">Proceed to Payment</a>
            </div>
        <?php endif; 
        
        // Get package details
        $pid=intval($_GET['pkgid']);
        $sql = "SELECT * from tbltourpackages where PackageId=:pid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pid', $pid, PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {	
        ?>
                <!-- Booking form -->
                <form name="book" method="post">
                    <div class="selectroom_top">
                        <!-- Package image -->
                        <div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
                            <img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
                        </div>
                        
                        <!-- Package details -->
                        <div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
                            <h2 style="color:#55d81c;"><?php echo htmlentities($result->PackageName);?></h2>
                            <p class="dow">#PKG-<?php echo htmlentities($result->PackageId);?></p>
                            <p><b>Package Type :</b> <?php echo htmlentities($result->PackageType);?></p>
                            <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation);?></p>
                            <p><b>Features</b> <?php echo htmlentities($result->PackageFetures);?></p><br>
                            <h2 style="color:green; font-size: 20px;"><b>Rooms Available:</b> <?php echo htmlentities($result->rooms);?></h2>
                            
                            <!-- Date selection -->
                            <div class="ban-bottom">
                                <div class="bnr-right">
                                    <label class="inputLabel">From</label>
                                    <input class="date" id="datepicker" type="text" placeholder="dd-mm-yyyy" name="fromdate" required="">
                                </div>
                                <div class="bnr-right">
                                    <label class="inputLabel">To</label>
                                    <input class="date" id="datepicker1" type="text" placeholder="dd-mm-yyyy" name="todate" required="">
                                </div>
                            </div>
                            
                            <!-- Room selection -->
                            <div style="font-weight: bolder; margin-top:150px;">      
                                <label>Rooms To Book:</label>
                                <input type="number" min="1" name="rooms" id="number" required size="15px">
                            </div>
                            <div class="clearfix"></div>
                            
                            <!-- Price calculation -->
                            <div class="grand">
                                <p style="color: orange;"><b>PricePerDay</b></p>
                                <h4>Ksh. <?php 
                                    $price=htmlentities($result->PackagePrice);
                                    echo htmlentities($price);
                                ?>
                                <br><label style="color: orange;">Total Price:</label><br>
                                <span id="totalPrice" style="text-decoration: underline;">0</span>
                                <input type="hidden" name="totalprice" id="totalPriceInput">

                                <!-- JavaScript for dynamic price calculation -->
                                <script>
                                    // Get references to input elements
                                    var roomsInput = document.getElementById('number');
                                    var fromDateInput = document.getElementById('datepicker');
                                    var toDateInput = document.getElementById('datepicker1');
                                    var totalPriceSpan = document.getElementById('totalPrice');

                                    // Add event listeners for price calculation
                                    roomsInput.addEventListener('input', updateTotalPrice);
                                    fromDateInput.addEventListener('input', updateTotalPrice);
                                    toDateInput.addEventListener('input', updateTotalPrice);

                                    // Price calculation function
                                    function updateTotalPrice() {
                                        var rooms = parseInt(roomsInput.value, 10) || 0;
                                        var fromDate = new Date(fromDateInput.value);
                                        var toDate = new Date(toDateInput.value);

                                        // Check for valid dates
                                        if (!isNaN(fromDate.getTime()) && !isNaN(toDate.getTime())) {
                                            var oneDay = 24 * 60 * 60 * 1000;
                                            var numberOfDays = Math.round(Math.abs((fromDate - toDate) / oneDay));
                                            var pricePerDay = parseFloat('<?php echo htmlentities($price); ?>') || 0;
                                            var totalPrice = rooms * numberOfDays * pricePerDay;

                                            // Update display and hidden field
                                            totalPriceSpan.textContent = 'Ksh. ' + totalPrice.toFixed(2);
                                            document.getElementById('totalPriceInput').value = totalPrice.toFixed(2);
                                        } else {
                                            totalPriceSpan.textContent = 'Ksh. 0.00';
                                            document.getElementById('totalPriceInput').value = '0.00';
                                        }
                                    }

                                    // Load saved booking data if available
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var storedRooms = localStorage.getItem('rooms');
                                        var storedFromDate = localStorage.getItem('fromDate');
                                        var storedToDate = localStorage.getItem('toDate');
                                        var storedTotalPrice = localStorage.getItem('totalPrice');

                                        if (storedRooms && storedFromDate && storedToDate && storedTotalPrice) {
                                            roomsInput.value = storedRooms;
                                            fromDateInput.value = storedFromDate;
                                            toDateInput.value = storedToDate;
                                            totalPriceSpan.textContent = 'Ksh. ' + storedTotalPrice;
                                            document.getElementById('totalPriceInput').value = storedTotalPrice;
                                        }
                                    });
                                </script>
                            </h4>
                        </div>
                    </div>
                    
                    <!-- Package details -->
                    <h3><b>Package Details</b></h3>
                    <p style="font-size:15px;"><?php echo htmlentities($result->PackageDetails);?> </p>    
                    <div class="clearfix"></div>
                    
                    <!-- Comment and booking button -->
                    <div class="selectroom_top">
                        <div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
                            <ul>
                                <li class="spe">
                                    <label class="inputLabel">Comment</label>
                                    <input class="special" type="text" name="comment" required="">
                                </li>
                                <?php if($_SESSION['login']): ?>
                                    <li class="spe" align="center">
                                        <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                                    </li>
                                <?php else: ?>
                                    <li class="sigi" align="center" style="margin-top: 1%">
                                        <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn"> Book</a>
                                    </li>
                                <?php endif; ?>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </form>
        <?php 
            } 
        } 
        ?>
    </div>
</div>

<!-- Include footer and modals -->
<?php include('includes/footer.php');?>
<?php include('includes/signup.php');?>    <!-- Signup modal -->
<?php include('includes/signin.php');?>    <!-- Signin modal -->
<?php include('includes/write-us.php');?>  <!-- Contact modal -->
</body>
</html>