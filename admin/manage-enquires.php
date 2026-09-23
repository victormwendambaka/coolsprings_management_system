<?php
session_start();
error_reporting(0); // Not recommended for production - hides errors
include('includes/config.php');

// Check if admin is logged in, redirect if not
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
}
else {
    // Code for marking enquiry as read
    if(isset($_REQUEST['eid'])) {
        $eid = intval($_GET['eid']);
        $status = 1;

        $sql = "UPDATE tblenquiry SET Status=:status WHERE id=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status',$status, PDO::PARAM_STR);
        $query->bindParam(':eid',$eid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Enquiry successfully read";
    }

    // Code for deletion
    if($_GET['action']=='delete') {
        $id = intval($_GET['id']);
        $sql = "DELETE FROM tblenquiry WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        
        echo "<script>alert('Enquiry deleted.');</script>";
        echo "<script>window.location.href='manage-enquires.php'</script>";
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu | Admin manage Bookings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
<script src="js/jquery-2.1.4.min.js"></script>

<!-- Table styling -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>

<!-- Table initialization script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').basictable();
        // Other table configuration options...
    });
</script>

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

        <!-- Breadcrumb navigation -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Manage Enquiries</li>
        </ol>

        <div class="agile-grids">    
            <!-- Display success/error messages -->
            <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
            else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
            
            <!-- Enquiries table -->
            <div class="agile-tables">
                <div class="w3l-table-info">
                    <h2>Manage Enquiries</h2>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Ticket id</th>
                                <th>Name</th>
                                <th>Mobile No./ Email</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th width="250">Posting date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT * from tblenquiry";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            if($query->rowCount() > 0) {
                                foreach($results as $result) {              
                            ?>        
                            <tr>
                                <td width="120">#TCKT-<?php echo htmlentities($result->id);?></td>
                                <td width="50"><?php echo htmlentities($result->FullName);?></td>
                                <td width="50"><?php echo htmlentities($result->MobileNumber);?> /<br />
                                <?php echo $result->EmailId;?></td>
                                <td width="200"><?php echo htmlentities($result->Subject);?></a></td>
                                <td width="400"><?php echo htmlentities($result->Description);?></td>
                                <td width="50"><?php echo htmlentities($result->PostingDate);?></td>
                                <?php if($result->Status==1) { ?>
                                    <td>Read | 
                                        <a href="manage-enquires.php?action=delete&&id=<?php echo $result->id;?>" onclick="return confirm('Do you really want to delete?')" style="color:red">Delete</a>
                                    </td>
                                <?php } else { ?>
                                    <td>
                                        <a href="manage-enquires.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to read')">Pending</a> | 
                                        <a href="manage-enquires.php?action=delete&&id=<?php echo $result->id;?>" onclick="return confirm('Do you really want to delete?')" style="color:red">Delete</a>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>

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