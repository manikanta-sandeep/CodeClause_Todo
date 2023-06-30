<?php
session_start();
include "header.php";
?>
<section class="py-5 text-center container">
        <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">
                Your Profile
            </h1>
          </div>
          </div>
      </section>
    <div class="container">
  
  <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-3">

<?php


 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else{
    $creator_id = $_SESSION["id"];
}
// Include config file
include "db_connection.php";



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$todo_err = "";
 

$link = OpenCon();

$sql = "SELECT username, email, dob, password, last_updated FROM User WHERE user_id = ?";
        
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_uid);
    
    // Set parameters
    $param_uid = $creator_id;
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
        
        // Check if email exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $username, $email, $dob, $hashed_password, $last_updated);
            if(mysqli_stmt_fetch($stmt)){
?>


            <div class="col">
                <div class="container-fluid create-account-container">
                    <div class="row ">
                        <div class="col">

                                <div class="form-group">
                                    <label for="exampleDropdownFormEmail2">Email address</label>
                                    <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="<?php echo $email; ?>" name="email" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="exampleDropdownFormEmail2">Username</label>
              
                                    <input type="text" class="form-control" id="exampleDropdownFormEmail2" placeholder="<?php echo $username; ?>" name="username" disabled>
                                                                               
                                </div>  
            
                                <div class="form-group">
                                    <label for="exampleDropdownFormEmail2">Date of Birth</label>
                                    <input type="text" class="form-control" id="exampleDropdownFormEmail2" name="dob" placeholder="<?php echo $dob; ?>" disabled>
                                   
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Enter Password</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password Secured" name="password" disabled>
                                </div>

                                <div class="text-center mt-2"><p>Last Updated at : <?php echo $last_updated; ?> </p></div>

                                <hr class="my-4">
                                <div class="text-center"><a href="update_user.php" class="btn btn-primary my-2">Update Profile</a></div>
                                
                        </div>
                    </div>
                </div>
            </div>
            

<?php

            }
        } else{
            // email doesn't exist, display a generic error message
            header("location: login.php");
        }
    } else{
        header("location: login.php");
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
}

?>
  </div>
<?php
  include "footer.php";
?>