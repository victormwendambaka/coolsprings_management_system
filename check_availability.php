<?php 
// Include database configuration file
require_once("includes/config.php");

// Check if email availability check was requested via POST
if(!empty($_POST["emailid"])) {
    // Get the email from POST data
    $email= $_POST["emailid"];
    
    // Validate email format using PHP filter
    if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
        // Return error if email format is invalid
        echo "error : You did not enter a valid email.";
    }
    else {
        // SQL query to check if email exists in database
        $sql ="SELECT EmailId FROM tblusers WHERE EmailId=:email";
        
        // Prepare the SQL statement to prevent SQL injection
        $query= $dbh->prepare($sql);
        
        // Bind the email parameter to the prepared statement
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        
        // Execute the query
        $query->execute();
        
        // Fetch results as objects
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1; // Counter variable (not used in this snippet)
        
        // Check if email already exists (row count > 0)
        if($query->rowCount() > 0) {
            // Display error message in red if email exists
            echo "<span style='color:red'> Email already exists .</span>";
            
            // Disable submit button using jQuery
            echo "<script>$('#submit').prop('disabled',true);</script>";
        } else {
            // Display success message in green if email is available
            echo "<span style='color:green'> Email available for Registration .</span>";
            
            // Enable submit button using jQuery
            echo "<script>$('#submit').prop('disabled',false);</script>";
        }
    }
}
?>