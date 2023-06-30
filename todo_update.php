<?php
session_start();


 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else{
    $creator_id = $_SESSION["id"];
    $todo_id = $_SESSION['todo_id'];
}
// Include config file
include "db_connection.php";



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$todo_err = "";
 

$link = OpenCon();


$sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE todo_id = ?";

        
if($stmt2 = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt2, "s", $param_tid);
    
    // Set parameters
    $param_tid = $todo_id;
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt2)){
        // Store result
        mysqli_stmt_store_result($stmt2);
        
        // Check if email exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt2) == 1){                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt2, $tid, $tit, $des, $sta, $dc, $dea, $lu, $pri);

            if(mysqli_stmt_fetch($stmt2)){
                // Processing form data when form is submitted
                if($_SERVER["REQUEST_METHOD"] == "POST"){

                    // Check if title is empty
                    if(empty(trim($_POST["title"]))){
                        $new_title = $tit;
                    } else{
                        $new_title = trim($_POST["title"]);
                    }

                    // Check if description is empty
                    if(empty(trim($_POST["description"]))){
                        $new_description = $des;
                    } else{
                        $new_description = trim($_POST["description"]);
                    }

                    // Check if status is empty
                    if(empty(trim($_POST["status"]))){
                        $new_status = $sta;
                    } else{
                        $new_status = trim($_POST["status"]);
                    }
                    
                    
                    // Check if deadline is empty
                    if(empty(trim($_POST["deadline"]))){
                        $new_deadline = $dea;
                    } else{
                        $new_deadline = trim($_POST["deadline"]);
                    }

                    // Check if priority is empty
                    if(empty(trim($_POST["priority"]))){
                        $new_priority = $pri;
                    } else{
                        $new_priority = trim($_POST["priority"]);
                    }
                
                    // Prepare a select statement
                    $sql = "UPDATE Todo SET title = ?, description = ?, status = ?, deadline = ?, last_updated = ?, priority = ? WHERE todo_id = ?";
                    
                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sssssss", $param_tit, $param_des, $param_sta, $param_dea, $currentTime , $param_pri, $param_tid);
                        
                        date_default_timezone_set('Asia/Kolkata');
                        $currentTime = date( 'd-m-Y h:i:s A', time () );
                        
                        echo '<br/>'.$new_username.'<br/>';

                        // Set parameters
                        $param_tit = $new_title;
                        $param_des = $new_description;
                        $param_sta = $new_status;
                        $param_dea = $new_deadline;
                        $param_tid = $tid;
                        $param_pri = $new_priority;

                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){

                            // Close statement
                            mysqli_stmt_close($stmt);

                            // Close connection
                            mysqli_close($link);
                            // Store result
                            header("location: home.php");
                            
                        } else{
                            // Close statement
                            mysqli_stmt_close($stmt);

                            // Close connection
                            mysqli_close($link);

                            echo "Oops! Something went wrong. Please try again later.";

                        }
                    }
                
                    
                    
                }
                else{
                    header("location: home.php");
                }
            }else{
                // email doesn't exist, display a generic error message
                header("location: home.php");
            }
        } else{
            header("location: login.php");
        }

        // Close statement
        mysqli_stmt_close($stmt2);

        // Close connection
        mysqli_close($link);
    }
    
}        


?>