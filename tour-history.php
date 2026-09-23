<?php
// Start session to manage user login state
session_start();

// Disable error reporting for production environment
error_reporting(0);

// Include database configuration file
include('includes/config.php');

// Check if user is logged in, redirect to index if not
if(strlen($_SESSION['login'])==0)
{	
    header('location:index.php');
}
else{
    // Check if booking cancellation request is made
    if(isset($_REQUEST['bkid']))
    {
        // Get booking ID from request and sanitize it
        $bid=intval($_GET['bkid']);
        $email=$_SESSION['login'];
        
        // Query to get booking details for the logged in user
        $sql ="SELECT FromDate FROM tblbooking WHERE UserEmail=:email and BookingId=:bid";
        $query= $dbh -> prepare($sql);
        $query-> bindParam(':email', $email, PDO::PARAM_STR);
        $query-> bindParam(':bid', $bid, PDO::PARAM_STR);
        $query-> execute();
        $results = $query -> fetchAll(PDO::FETCH_OBJ);

        // If booking exists
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {
                $fdate=$result->FromDate;

                // Format date for comparison
                $a=explode("/",$fdate);
                $val=array_reverse($a);
                $mydate =implode("/",$val);
                $cdate=date('Y/m/d');
                $date1=date_create("$cdate");
                $date2=date_create("$fdate");
                $diff=date_diff($date1,$date2);
                echo $df=$diff->format("%a");
                
                // Check if cancellation is allowed (more than 1 day before)
                if($df>1)
                {
                    $status=2;
                    $cancelby='u';
                    
                    // Update booking status to cancelled
                    $sql = "UPDATE tblbooking SET status=:status,CancelledBy=:cancelby WHERE UserEmail=:email and BookingId=:bid";
                    $query = $dbh->prepare($sql);
                    $query -> bindParam(':status',$status, PDO::PARAM_STR);
                    $query -> bindParam(':cancelby',$cancelby , PDO::PARAM_STR);
                    $query-> bindParam(':email',$email, PDO::PARAM_STR);
                    $query-> bindParam(':bid',$bid, PDO::PARAM_STR);
                    $query -> execute();

                    // Query to get booking details for room availability update
                    $sql3 = "SELECT tblbooking.BookingId as bookid,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,tbltourpackages.PackageName as pckname,tblbooking.PackageId as pid,tblbooking.FromDate as fdate,DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays,tbltourpackages.PackagePrice as price, tblbooking.ToDate as tdate,tblbooking.roomsbooked as roomsbooked, tbltourpackages.rooms as roomsav, tblbooking.Comment as comment,tblbooking.status as status,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblusers join  tblbooking on  tblbooking.UserEmail=tblusers.EmailId join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId";
                    $query = $dbh -> prepare($sql3);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    
                    // Update room availability after cancellation
                    if($query->rowCount() > 0)
                    {
                        foreach($results as $result)
                        {
                            $pid=$result->pid;
                            $lastday=$result->tdate;
                            $booked=$result->roomsbooked;
                            $remain=$result->roomsav;
                            $rr=($booked+$remain);
                            
                            // Update available rooms count
                            $con="UPDATE TblTourPackages SET rooms=:rr WHERE PackageId=:pid";
                            $newrooms = $dbh->prepare($con);
                            $newrooms-> bindParam(':rr', $rr, PDO::PARAM_STR);
                            $newrooms-> bindParam(':pid', $pid, PDO::PARAM_STR);
                            $newrooms->execute();
                        }
                    }
                    $msg="Booking Cancelled successfully";
                }
                else
                {
                    $error="You can't cancel booking before 24 hours";
                }
            }
        }
    }
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Lamu  | Tourism Management System</title>
<!-- Meta tags for responsive design -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Tourism Management System In PHP" />

<!-- JavaScript to hide address bar on mobile devices -->
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

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

<!-- Custom styles for error/success messages -->
<style>
    .errorWrap {
        font-size: 16px;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .succWrap{
        font-size: 16px;
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
<?php include('includes/header.php');?> <!-- Include header -->

<!-- Banner section with animation -->
<div class="banner-1 ">
    <div class="container">
        <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Lamu - Tourism Management System</h1>
    </div>
</div>

<!-- Main content section -->
<div class="privacy">
    <div class="container">
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">My Tour History</h3>
        <form name="chngpwd" method="post" onSubmit="return valid();">
            <!-- Display error/success messages -->
            <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <p>
        <!-- Booking history table -->
        <table border="1" width="100%">
            <tr align="center">
                <th>#</th>
                <th>Booking Id</th>
                <th>Package Name</th>	
                <th>From</th>
                <th>To</th>
                <th>TotalDays</th>
                <th>Rooms Picked</th>
                <th>PricePerDay</th>
                <th>TotalBilled</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Booking Date</th>
                <th>Action</th>
            </tr>
            <?php 
            // Query to get user's booking history
            $uemail=$_SESSION['login'];;
            $sql = "SELECT tblbooking.BookingId as bookid,tblbooking.PackageId as pkgid,tbltourpackages.PackageName as packagename,tblbooking.FromDate as fromdate,tblbooking.ToDate as todate,DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays, tblbooking.Comment as comment,tblbooking.status as status,tbltourpackages.PackagePrice as price ,tblbooking.roomsbooked as rooms, tblbooking.RegDate as regdate,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblbooking join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId where UserEmail=:uemail";
            $query = $dbh->prepare($sql);
            $query -> bindParam(':uemail', $uemail, PDO::PARAM_STR);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            
            // Display booking history if exists
            if($query->rowCount() > 0)
            {
                foreach($results as $result)
                {	?>
                <tr align="center">
                    <td><?php echo htmlentities($cnt);?></td>
                    <td>#BK<?php echo htmlentities($result->bookid);?></td>
                    <td><a href="package-details.php?pkgid=<?php echo htmlentities($result->pkgid);?>"><?php echo htmlentities($result->packagename);?></a></td>
                    <td><?php echo htmlentities($fd=$result->fromdate);?></td>
                    <td><?php echo htmlentities($tdd=$result->todate);?></td>
                    <td><?php echo htmlentities($tds=$result->totaldays);?></td>
                    <td><?php echo htmlentities($rooms=$result->rooms);?></td>
                    <td><?php echo htmlentities($pr=$result->price);?></td>
                    <td><?php echo htmlentities($tds*$pr*$rooms);?></td>
                    <td><?php echo htmlentities($result->comment);?></td>
                    <td><?php 
                        // Display booking status with appropriate message
                        if($result->status==0) {
                            echo "Pending";
                        }
                        if($result->status==1) {
                            echo "Confirmed";
                        }
                        if($result->status==2 and  $result->cancelby=='u') {
                            echo "Canceled by you at " .$result->upddate;
                        } 
                        if($result->status==2 and $result->cancelby=='a') {
                            echo "Canceled by admin at " .$result->upddate;
                        }
                    ?></td>
                    <td><?php echo htmlentities($result->regdate);?></td>
                    <?php 
                    // Show appropriate action based on booking status
                    if($result->status==2) { ?>
                        <td>Cancelled</td>
                    <?php } elseif($result->status==1) { ?>
                        <td>Paid</td>
                    <?php } else { ?>
                        <td><a href="tour-history.php?bkid=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Do you really want to cancel booking')">Cancel</a></td>
                    <?php } ?>
                </tr>
                <?php $cnt=$cnt+1; }} ?>
        </table>
        </p>
        </form>
    </div>
</div>
<!--- /privacy ---->

<!-- Include footer and modal popups -->
<?php include('includes/footer.php');?>
<?php include('includes/signup.php');?> <!-- Signup modal -->			
<?php include('includes/signin.php');?> <!-- Signin modal -->			
<?php include('includes/write-us.php');?> <!-- Contact us modal -->
</body>
</html>
<?php } ?>