<?php
// Define constants for database credentials
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','lamu db');

// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

// Connect to the database
$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Function to fetch users data from the database
function getUsersData($dbh) {
    $stmt = $dbh->prepare("SELECT id,FullName, MobileNumber,EmailId , RegDate, UpdationDate FROM tblusers");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Function to fetch booking data from the database
function getBookingData($dbh) {
    $stmt = $dbh->prepare("SELECT BookingId,UserEmail, FromDate,ToDate,roomsbooked,Totalprice FROM tblbooking");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Function to fetch issues data from the database
function getIssuesData($dbh) {
    $stmt = $dbh->prepare("SELECT id,UserEmail, issue,PostingDate,AdminRemark,AdminremarkDate FROM tblissues");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Function to fetch enquires data from the database
function getEnquiresData($dbh) {
    $stmt = $dbh->prepare("SELECT id,FullName,MobileNumber,Subject,PostingDate,status FROM tblenquiry");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Function to fetch packages data from the database
function getPackagesData($dbh) {
    $stmt = $dbh->prepare("SELECT Packageid,PackageName,Packageprice,rooms,CreationDate,UpdationDate FROM tbltourpackages");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Function to fetch payments data from the database
function getPaymentsData($dbh) {
    $stmt = $dbh->prepare("SELECT Pid,amount,mobilenumber,status FROM tblpayments");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Function to generate PDF report
function generateReport($reportName, $columns, $data) {
    // Check if data array is not empty
    if (empty($data)) {
        echo "No data available for report generation.";
        return;
    }

   // Create new PDF document with landscape orientation
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Lamu Tourist Management System');
$pdf->SetTitle($reportName);
$pdf->SetSubject($reportName);

// Add a page
$pdf->AddPage();

// Set title font and color
$pdf->SetFont('times', 'B', 20); // Change font to Times, bold, size 20
$pdf->SetTextColor(255, 0, 0); // Set text color to red (RGB)


// Add image
$imageFile = 'images/logo.png'; // Replace 'path/to/your/image.jpg' with the actual path to your image file

// Get the dimensions of the image
list($imageWidth, $imageHeight) = getimagesize($imageFile);

// Calculate the position to center the image horizontally
$imageX = ($pdf->GetPageWidth() - $imageWidth) / 1.25;

// Set the position to center the image horizontally at the top of the page
$pdf->SetXY($imageX, $pdf->GetY());

// Add the image
$pdf->Image($imageFile, $pdf->GetX(), $pdf->GetY(), 40); // Adjust the parameters as needed

// Add a line break after the image
$pdf->Ln(40); // Move to the next line
// Add title
$pdf->Cell(0, 10, 'Lamu Tourist Management System - ' . $reportName, 0, 1, 'C');

// Add space between title and column headers
$pdf->Ln(10); // Adjust the value (10) as needed for the desired space
// Reset font and color
$pdf->SetFont('helvetica', '', 12); // Reset font to Helvetica, regular, size 12
$pdf->SetTextColor(0, 0, 0); // Reset text color to black (RGB)

// Add column headers
foreach ($columns as $column) {
    $pdf->SetFont('helvetica', '', 12); // Reset font to Helvetica, regular, size 12
    $pdf->Cell(45, 10, $column, 1, 0, 'C', 0); // Increased width to 45
}
$pdf->Ln(); // Move to the next line

// Add data rows
foreach ($data as $row) {
    foreach ($row as $column) {
        $pdf->SetFont('helvetica', '', 12); // Reset font to Helvetica, regular, size 12
        $pdf->Cell(45, 10, $column, 1, 0, 'C', 0); // Increased width to 45
    }
    $pdf->Ln(); // Move to the next line for the next row
}




// Output PDF
$pdf->Output($reportName . '.pdf', 'D');
}
// Generate the appropriate report based on the report type
if (isset($_GET['report_type'])) {
    $reportType = $_GET['report_type'];

    // Generate the appropriate report based on the report type
    switch ($reportType) {
        case 'users':
            // Generate users report
            $usersData = getUsersData($db);
            generateReport('Users Report', ['NO', 'NAME', 'MOBILE NUMBER','EMAIL' ,'REG DATE', 'UPDATION DATE'], $usersData);
            break;
        case 'booking':  
            // Generate bookingreport
            $bookingData = getBookingData($db);
            generateReport('Booking Report', ['NO.','EMAIL', 'FROM DATE','TO DATE','ROOMS BOOKED','TOTAL PRICE',], $bookingData);
            break;
        case 'issues':  
            // Generate issues report
            $issuesData = getIssuesData($db);
            generateReport('Issues Report', ['NO.','EMAIL', 'ISSUE','POSTING DATE','ADMIN REMARK','ADMIN REMARK DATE'], $issuesData);
            break;
        case 'enquires':  
            // Generate enquires report
            $enquiresData = getEnquiresData($db);
            generateReport('Enquires Report', ['NO.','FULL NAME','MOBILE NUMBER','SUBJECT','POSTING DATE', 'STATUS'], $enquiresData);
            break;     
        case 'packages':
            $packagesData = getPackagesData($db);
            generateReport('Packages Report', ['NO.','NAME','PACKAGE PRICE','ROOMS AVAILABLE','CREATION DATE','UPDATION DATE'], $packagesData);
            break;
        case 'payments':
            $paymentsData = getPaymentsData($db);
            generateReport('Payments Report', ['NO.','AMOUNT','MOBILE NUMBER','STATUS'], $paymentsData);
            break;

        
        default:
            echo "Invalid report type.";
            break;
    }
} else {
    echo "Report type parameter is missing.";
}