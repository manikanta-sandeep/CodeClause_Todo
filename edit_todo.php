<?php

session_start();

if($_GET){
    $todoid = $_GET['todo']; // print_r($_GET); //remember to add semicolon  
    $_SESSION["todo_id"] = $todoid;  
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
    
    $sql = "SELECT todo_id, creator_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = ? AND todo_id = ?";
    
            
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
                mysqli_stmt_bind_result($stmt2, $newtodo, $cid, $tit, $des, $sta, $dc, $dea, $lu, $pri);

                if(mysqli_stmt_fetch($stmt2)){
                    echo '';
                }
            }else{
                $delete_err = "You are not authorized to update this todo";
            }
        }
    }

?>


<?php
  include "header.php";

?>

<section class="py-5 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">
                Update Todo
            </h1>
            <?php 
                if(!empty($delete_err)){
                    echo '<div class="alert alert-danger">' . $delete_err . '</div><a href="home.php" class="btn btn-primary my-2">Go to Home</a>';
                } 
            ?>
        </div>
    </div>
</section>
<?php 
  if(empty($delete_err)){
?>
<div class="container">
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-3">
    <div class="container-fluid create-account-container">
                <div class="row g-5 detail-row">
                        
                <div class="col col-mid-8">
                <div class="row g-3">
                <form action="todo_update.php" method="post">
                    <div class="col-12">
                        <label for="email" class="form-label">Title</label>
                        <input type="text" class="form-control" id="exampleDropdownFormEmail2" placeholder="<?php echo $tit; ?>" name="title">
                    </div>
                    

                    <div class="col-12">
                        <label  class="form-label">Description</label>
                        <div class="input-group has-validation">
                        <textarea class="form-control" aria-label="With textarea" placeholder="<?php echo $des; ?>" name="description"></textarea>
                        
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
                        <option  <?php echo ($pri == 0 ? "selected" : "") ?> value="0">No Priority</option>
                        <option <?php echo ($pri == 5 ? "selected" : "") ?> value="5">Five</option>
                        <option <?php echo ($pri == 4 ? "selected" : "") ?> value="4">Four</option>
                        <option <?php echo ($pri == 3 ? "selected" : "") ?> value="3">Three</option>
                        <option <?php echo ($pri == 2 ? "selected" : "") ?> value="2">Two</option>
                        <option <?php echo ($pri == 1 ? "selected" : "") ?> value="1">One</option>
                        
                    </select>
                    </div>

                    <div class="col-12">
                        <label  class="form-label">Status</label>
                        <div class="form-check">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="0" <?php echo ($sta == 0 ? "checked" : "") ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Incomplete
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1" <?php echo ($sta == 0 ? "" : "checked") ?>>
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
}
  include "footer.php";
?>


