<?php
// Start session for user authentication
session_start();
// Turn off error reporting (not recommended for production)
error_reporting(0);
// Include database configuration
include('includes/config.php');

// Check if admin is logged in, redirect if not
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
}
else {
    // Package creation form processing
    if(isset($_POST['submit'])) {
        // Collect form data
        $pname=$_POST['packagename'];
        $ptype=$_POST['packagetype'];    
        $plocation=$_POST['packagelocation'];
        $pprice=$_POST['packageprice'];
        $prooms=$_POST['rooms'];    
        $pfeatures=$_POST['packagefeatures'];
        $pdetails=$_POST['packagedetails'];    
        $pimage=$_FILES["packageimage"]["name"];
        
        // Move uploaded file to server
        move_uploaded_file($_FILES["packageimage"]["tmp_name"],"pacakgeimages/".$_FILES["packageimage"]["name"]);
        
        // SQL to insert new package
        $sql="INSERT INTO tbltourpackages(PackageName,PackageType,PackageLocation,PackagePrice,rooms,PackageFetures,PackageDetails,PackageImage) VALUES(:pname,:ptype,:plocation,:pprice,:prooms,:pfeatures,:pdetails,:pimage)";
        $query = $dbh->prepare($sql);
        
        // Bind parameters (security measure against SQL injection)
        $query->bindParam(':pname',$pname,PDO::PARAM_STR);
        $query->bindParam(':ptype',$ptype,PDO::PARAM_STR);
        $query->bindParam(':plocation',$plocation,PDO::PARAM_STR);
        $query->bindParam(':pprice',$pprice,PDO::PARAM_STR);
        $query->bindParam(':prooms',$prooms,PDO::PARAM_STR);
        $query->bindParam(':pfeatures',$pfeatures,PDO::PARAM_STR);
        $query->bindParam(':pdetails',$pdetails,PDO::PARAM_STR);
        $query->bindParam(':pimage',$pimage,PDO::PARAM_STR);
        
        // Execute query
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        
        // Set success/error messages
        if($lastInsertId) {
            $msg="Package Created Successfully";
        }
        else {
            $error="Something went wrong. Please try again";
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu | Admin Package Creation</title>

<!-- Mobile viewport optimization -->
<script type="application/x-javascript"> 
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
    function hideURLbar(){ window.scrollTo(0,1); } 
</script>

<!-- CSS includes -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 

<!-- JavaScript includes -->
<script src="js/jquery-2.1.4.min.js"></script>

<!-- Google Fonts -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

<!-- Custom styles for error/success messages -->
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
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
       <div class="mother-grid-inner">
              <!-- Include header -->
              <?php include('includes/header.php');?>
                            
                     <div class="clearfix"> </div>    
                </div>
<!-- Header end here -->

<!-- Breadcrumb navigation -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Create Package </li>
</ol>

<!-- Main form container -->
<div class="grid-form">
    <div class="grid-form1">
        <h3>Create Package</h3>
        
        <!-- Display success/error messages -->
        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        
        <!-- Package creation form -->
        <div class="tab-content">
            <div class="tab-pane active" id="horizontal-form">
                <form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
                    <!-- Package Name -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Package Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="packagename" id="packagename" placeholder="Create Package" required>
                        </div>
                    </div>
                    
                    <!-- Package Type -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Package Type</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="packagetype" id="packagetype" placeholder="Package Type eg- Family Package / Couple Package / Business package" required>
                        </div>
                    </div>

                    <!-- Package Location -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Package Location</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="packagelocation" id="packagelocation" placeholder="Package Location" required>
                        </div>
                    </div>

                    <!-- Package Price -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Package Price in KSH</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="packageprice" id="packageprice" placeholder="Package Price is KSH" required>
                        </div>
                    </div>
                    
                    <!-- Available Rooms -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Available Rooms</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="rooms" id="rooms" placeholder="rooms available" required>
                        </div>
                    </div>

                    <!-- Package Features -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Package Features</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control1" name="packagefeatures" id="packagefeatures" placeholder="Package Features Eg-free Pickup-drop facility" required>
                        </div>
                    </div>        

                    <!-- Package Details -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Package Details</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="5" cols="50" name="packagedetails" id="packagedetails" placeholder="Package Details" required></textarea> 
                        </div>
                    </div>                                                            
                    
                    <!-- Package Image -->
                    <div class="form-group">
                        <label for="focusedinput" class="col-sm-2 control-label">Package Image</label>
                        <div class="col-sm-8">
                            <input type="file" name="packageimage" id="packageimage" required>
                        </div>
                    </div>    

                    <!-- Form buttons -->
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" name="submit" class="btn-primary btn">Create</button>
                            <button type="reset" class="btn-inverse btn">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--//grid-->

<!-- Sticky navigation script -->
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

<!-- Include footer -->
<?php include('includes/footer.php');?>

<!-- Include sidebar menu -->
<?php include('includes/sidebarmenu.php');?>

<!-- JavaScript files -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
<?php } ?>