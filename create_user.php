<?php
// Include config file
include "db_connection.php";



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Open Connection
    $link = OpenCon();

    // Validate username
    if(empty(trim($_POST["username"]))){
        $email_err = "Please enter a username.";
    } else{
        
        // Prepare a select statement 
        $sql = "SELECT user_id FROM User WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already registered.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["cnf_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["cnf_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        $link = OpenCon();

        // Prepare an insert statement
        $sql = "INSERT INTO User (username, password, dob, email, date_joined, last_updated) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $param_dob, $param_email, $param_currentTime, $param_currentTime);
            
            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date( 'd-m-Y h:i:s A', time () );
            

            // Set parameters
            $param_username = trim($_POST["username"]);
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_currentTime = $currentTime;
            $param_email = $email;
            $param_dob = trim($_REQUEST['dob']);


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

    }
    
    CloseCon($link);
}
?>



<?php
  include "header2.php";

?>
<section class="py-5 text-center container">
    <div class="row py-lg-3">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">
                Create a User Account
            </h1>
            <p>Please fill this form to create an account.</p>
        </div>
    </div>
    </section>
<div class="container">
<div class="container-fluid">
    <div class="row">
        <div class="col  create-account-content">
            <div class="container-fluid  create-account-container">
                <div class="row ">
                    <div class="col create-content">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="col-mid-4 ">

                            <div class="form-group">
                                <label for="exampleDropdownFormEmail2">Email address</label>
                                <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter email address" name="email" required>
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="exampleDropdownFormEmail2">Username</label>
            
                                <input type="text" class="form-control" placeholder="Username/ Shortname" name="username" required>
                                                                            
                            </div>  
        
                            <div class="form-group">
                                <label for="exampleDropdownFormEmail2">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" required>
                                
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Enter Password</label>
                                <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Password" name="password" required>
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Confirm Password</label>
                                <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confrim Password" name="cnf_password" required>
                                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                            </div>
                            
                            
                            <br>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                            </div>
                            
                            <div class="text-center"><p>Already have an account? <a href="login.php">Login here</a>.</p></div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php
  include "footer.php";
?>

