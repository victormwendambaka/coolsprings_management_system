<?php
session_start();
error_reporting(0); // Not recommended for production
include('includes/config.php');

// Check admin login status
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
}
else {
    // Handle page content update
    if($_POST['submit']=="Update") {
        $pagetype = $_GET['type'];
        $pagedetails = $_POST['pgedetails'];
        
        $sql = "UPDATE tblpages SET detail=:pagedetails WHERE type=:pagetype";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pagetype',$pagetype,PDO::PARAM_STR);
        $query->bindParam(':pagedetails',$pagedetails,PDO::PARAM_STR);
        $query->execute();
        
        $msg = "Page data updated successfully";
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Lamu | Admin Page Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- CSS and JavaScript includes -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>

<!-- Rich text editor integration -->
<script type="text/javascript" src="nicEdit.js"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>

<!-- Form validation script -->
<script type="text/JavaScript">
function MM_validateForm() {
    // Validation logic here
}

function MM_jumpMenu(targ,selObj,restore) {
    // Page navigation logic
}
</script>

<!-- Custom styles for messages -->
<style>
    .errorWrap, .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .errorWrap { border-left: 4px solid #dd3d36; }
    .succWrap { border-left: 4px solid #5cb85c; }
</style>
</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
       <div class="mother-grid-inner">
            <!-- Header inclusion -->
            <?php include('includes/header.php');?>
            <div class="clearfix"> </div>    
        </div>

        <!-- Breadcrumb navigation -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Update Page Data</li>
        </ol>

        <!-- Main form container -->
        <div class="grid-form">
            <div class="grid-form1">
                <h3>Update Page Data</h3>
                
                <!-- Display success/error messages -->
                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div><?php } 
                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div><?php }?>
                
                <!-- Page selection form -->
                <div class="tab-content">
                    <div class="tab-pane active" id="horizontal-form">
                        <form class="form-horizontal" name="package" method="post">
                            <!-- Page selection dropdown -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Select page</label>
                                <div class="col-sm-8">
                                    <select name="menu1" onChange="MM_jumpMenu('parent',this,0)" class="form-control">
                                        <option value="" selected>***Select One***</option>
                                        <option value="manage-pages.php?type=terms">Terms and condition</option>
                                        <option value="manage-pages.php?type=privacy">Privacy and Policy</option>
                                        <option value="manage-pages.php?type=aboutus">About us</option>
                                        <option value="manage-pages.php?type=contact">Contact us</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Display selected page -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Selected Page</label>
                                <div class="col-sm-8">
                                    <?php
                                    switch($_GET['type']) {
                                        case "terms":
                                            echo "Terms and Conditions";
                                            break;
                                        case "privacy":
                                            echo "Privacy And Policy";
                                            break;
                                        case "aboutus":
                                            echo "About US";
                                            break;
                                        case "contact":
                                            echo "Contact Us";
                                            break;
                                        default:
                                            echo "";
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <!-- Page content editor -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Page Details</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="5" cols="50" name="pgedetails" id="pgedetails" required>
                                        <?php 
                                        $pagetype = $_GET['type'];
                                        $sql = "SELECT detail FROM tblpages WHERE type=:pagetype";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':pagetype',$pagetype,PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) {
                                                echo htmlentities($result->detail);
                                            }
                                        }
                                        ?>
                                    </textarea>
                                </div>
                            </div>
                            
                            <!-- Submit button -->
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button type="submit" name="submit" value="Update" class="btn-primary btn">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include footer and sidebar -->
        <?php include('includes/footer.php');?>
        <?php include('includes/sidebarmenu.php');?>

        <!-- JavaScript files -->
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>