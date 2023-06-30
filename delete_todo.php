<?php

session_start();

if($_GET){
    $todoid = $_GET['todo']; // print_r($_GET); //remember to add semicolon      
}else{
    header("location: home.php");
}


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
    
    $sql = "SELECT todo_id, creator_id, title, description, status, date_created, deadline, last_updated FROM Todo WHERE creator_id = ? AND todo_id = ?";
    
            
    if($stmt2 = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt2, "ss", $param_uid, $todoid);
        
        // Set parameters
        $param_uid = $creator_id;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt2)){
            // Store result
            mysqli_stmt_store_result($stmt2);
            
            // Check if email exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt2) == 1){                    
                // Bind result variables
                mysqli_stmt_bind_result($stmt2, $newtodo, $cid, $tit, $des, $sta, $dc, $dea, $lu);

                if(mysqli_stmt_fetch($stmt2)){
                    
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        // Processing form data when form is submitted
                        $sql = "DELETE FROM Todo WHERE todo_id = ?";
                        if($stmt2 = mysqli_prepare($link, $sql)){
                            mysqli_stmt_bind_param($stmt2, "s", $param_id);
            
                            // Set parameters
                            $param_id = $newtodo;
                            if(mysqli_stmt_execute($stmt2)){
                                header("location: home.php");
                                exit;
                            }

                        }
                    }
                }
            }else{
                $delete_err = "You are not authorized to delete this todo";
            }
        }
    }
    
    



?>


<?php
  include "header2.php";

?>

<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">
                Delete Confirmation Page
            </h1>
            <?php 
                if(!empty($delete_err)){
                    echo '<div class="alert alert-danger">' . $delete_err . '</div><a href="home.php" class="btn btn-primary my-2">Go to Home</a>';
                }
                if(empty($delete_err)){
            ?>
            
            <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalChoice">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-3 shadow">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Are you sure ?</h5>
                        <p class="mb-0">
                        <ul class="list-unstyled mt-3 mb-4">
                            <li><b>Title: </b> <?php echo $tit ?></li>
                            <li><b>Description: </b> <?php echo $des ?></li>
                            <li><b>Status: </b><?php echo ($sta == 1 ? "Completed" : "Incomplete") ?></li>
                            <li><b>Date Created: </b><?php echo $dc ?></li>
                            <li><b>Deadline: </b><?php echo $dea ?></li>
                            <li><b>Last Updated: </b><?php echo $lu ?></li>
                        </ul>
                        </p>
                    </div>
                    
                    <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
                    <div class="container-fluid">
                        <div class="row">
                            <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end"><strong>Delete</strong></button>
                            <a href="home.php" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-3 m-0 rounded-0" data-bs-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                    </form>

                    </div>
                </div>
            </div>
            <?php
                }
            ?>
            
        </div>
    </div>
</section>

<?php
  include "footer.php";
?>
