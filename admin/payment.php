<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu TMS | Manage Payments</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">      
				<?php include('includes/header.php');?>
				     <div class="clearfix"> </div>	
				</div>
<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Manage Payments</li>
            </ol>
<div class="agile-grids">	
				<!-- tables -->
				<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
			
<?php 
	if ($error) {
		echo '<div class="errorWrap"><strong>ERROR</strong>:' . htmlentities($error) . '</div>';
	} else if ($msg) {
		echo '<div class="succWrap"><strong>SUCCESS</strong>:' . htmlentities($msg) . '</div>';
	}
	?>
	
	<div class="agile-tables">
		<div class="w3l-table-info">
		<div style="display: flex; align-items: center;">
    <h4 style="margin-right: 5px; background-color: green; padding: 5px; 
	display: inline-block;">
	<a href="payment.php" style="text-decoration: none; color: white;">Confirmed Payments</a></h4>
    <span style="color: white;">|</span>
    <h4 style="margin-left: 5px; background-color: red; padding: 5px;
	 display: inline-block;"><a href="cancelledpayment.php" style="text-decoration: none; color: white;">Cancelled Payments</a></h4>
</div>

			<table id="table">
				<thead>
					<tr>
						<th>Booking id</th>
						<th>Name</th>
						<th>Mobile No.</th>
						<th>Email Id</th>
						<th>From /To </th>
						<th>Days </th>
						<th>Rooms </th>
						<th>PricePerDay </th>
						<th>Billed </th>
					</tr>
				</thead>
				<?php
$sql3 = "SELECT tblbooking.BookingId as bookid,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,tbltourpackages.PackageName as pckname,tblbooking.PackageId as pid,tblbooking.FromDate as fdate,DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays,tbltourpackages.PackagePrice as price, tblbooking.ToDate as tdate,tblbooking.roomsbooked as rooms, tblbooking.Comment as comment,tblbooking.status as status,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblusers join  tblbooking on  tblbooking.UserEmail=tblusers.EmailId join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId";
$query = $dbh->prepare($sql3);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
$overallTotal = 0;

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        if ($result->status == 1) { // Check if status is 1 (you can adjust the status value if needed)
            $dd = $result->totaldays;
            $rm = $result->rooms;
            $pr = $result->price;
            $tt = $dd * $pr * $rm;
            $overallTotal += $tt;
            ?>
            <tr>
                <td>#BK-<?php echo htmlentities($result->bookid); ?></td>
                <td><?php echo htmlentities($result->fname); ?></td>
                <td><?php echo htmlentities($result->mnumber); ?></td>
                <td><?php echo htmlentities($result->email); ?></td>
                <td><?php echo htmlentities($td = $result->fdate); ?> To <?php echo htmlentities($td = $result->tdate); ?></td>
                <td><?php echo htmlentities($dd); ?></td>
                <td><?php echo htmlentities($rm); ?></td>
                <td><?php echo htmlentities($pr); ?></td>
                <td><?php echo htmlentities($tt); ?></td>
               
            </tr>
<?php
        }
    }
}
echo 'Overall Total: ' . $overallTotal; // Display the overall total outside the loop
?>
<tr>
						<td colspan="9" style="font-size:20px;"><strong>Overall Total:</strong></td>
						<td style="font-size:20px;text-decoration:underline;"><strong><?php echo htmlentities($overallTotal); ?></strong></td>
						<td></td>
					</tr>
			</table>
		</div>
	</div>
		
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>	
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>	
						<td>&nbsp;</td>						
               
												
           </tr>
            <br>						 
						 </div>
						</tbody>
					  </table>
					</div>
				  </table>

				
			</div>
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });			 
		});
		</script>
<div class="inner-block">
</div>
<?php include('includes/footer.php');?>
</div>
</div>
						<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
								  }								
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
   <script src="js/bootstrap.min.js"></script>
	   

</body>
</html>
<?php  ?>