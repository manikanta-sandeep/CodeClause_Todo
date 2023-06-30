<?php
// Initialize the session
session_start();
 
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


// Define variables and initialize with empty values
$title = "";
$title_err = "";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Open Connection
    $link = OpenCon();

    // Validate username
   
    
    // Validate title
    if(empty(trim($_POST["title"]))){
        $title_err = "Please enter a title.";     
    } else{
        $title = trim($_POST["title"]);
    }
    
    
    
    // Check input errors before inserting in database
    if(empty($title_err)){
        
        $link = OpenCon();

        // Prepare an insert statement
        $sql = "INSERT INTO Todo (creator_id, title, description, status, date_created, deadline, last_updated, priority) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_cid, $param_title, $param_description, $param_status, $param_currentTime, $param_deadline, $param_currentTime, $param_priority);
            
            date_default_timezone_set('Asia/Kolkata');
            $currentTime = date( 'd-m-Y h:i:s A', time () );
            

            // Set parameters
            $param_cid = $creator_id;
            $param_title = $title;
            $param_description = $_REQUEST['description'];
            $param_status = $_REQUEST['status'];
            $param_deadline = $_REQUEST['deadline'];
            $param_priority = $_REQUEST['priority'];
            $param_currentTime = $currentTime;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: home.php");
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
  include "header.php";

?>
<section class="py-5 text-center container">
    <div class="row py-lg-3">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">
            Create a task
            </h1>
            <p>You can create a task here.</p>
        </div>
    </div>
    </section>
<div class="container">
<div class="container-fluid  create-account-container">
<div class="row g-5 detail-row">
        
        <div class="col col-mid-8">
          <h4 class="mb-3">Create Task</h4>

            <div class="row g-3">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="col-12">
                        <label for="email" class="form-label">Title</label>
                        <input type="text" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>"  id="exampleDropdownFormEmail2" placeholder="Enter a Title" name="title" required>
                        <span class="invalid-feedback"><?php echo $title_err; ?></span>
                    </div>
                    

                    <div class="col-12">
                        <label  class="form-label">Description</label>
                        <div class="input-group has-validation">
                        <textarea class="form-control" aria-label="With textarea" placeholder="Enter Description" name="description"></textarea>
                        
                        </div>
                    </div>
        
                    <div class="col-12">
                        <label  class="form-label">Deadline</label>
                        <div class="input-group has-validation">
                        <input type="datetime-local" class="form-control" id="exampleDropdownFormEmail2" name="deadline" >
                        <div class="invalid-feedback">
                            Your Date of Birth is required.
                        </div>
                        </div>
                    </div>

                    <div class="col-12">
                    <label  class="form-label">Priority</label>
                    <div class="input-group mb-3">
                    <select class="form-select" id="inputGroupSelect01" name="priority">
                        <option selected value="0">No Priority</option>
                        <option value="5">Five</option>
                        <option value="4">Four</option>
                        <option value="3">Three</option>
                        <option value="2">Two</option>
                        <option value="1">One</option>
                        
                    </select>
                    </div>
                
                    </div>

                    <div class="col-12">
                        <label  class="form-label">Status</label>
                        <div class="form-check">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="0" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Incomplete
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1" >
                            <label class="form-check-label" for="flexRadioDefault1">
                                Completed
                            </label>
                        </div>
                        
                        </div>
                    </div>
                    
                    <hr class="my-4">
        
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Create</button>
                </form>
            </div>      
        </div>
      </div>
</div>
<?php
  include "footer.php";
?>

