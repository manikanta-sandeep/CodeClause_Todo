<?php
session_start();
include "header.php";
?>
<section class="py-5 text-center container">
        <div class="row py-lg-5">
          <div class="col-lg-6 col-md-8 mx-auto">
              <h1 class="fw-light">
                  My Tasks
              </h1>
                <a href="create_todo.php" class="btn btn-primary my-2">Create a Task</a>
          </div>
          <form name="Table Properties" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          
          <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Sort By</label>
            <select class="form-select" id="inputGroupSelect01" name="sortkey">
              <option selected>Choose...</option>
              <option value="1">Priority High to Low</option>
              <option value="2">Priority Low to High</option>
              <option value="3">Incomplete</option>
              <option value="4">Complete</option>
              
            </select>
            <button class="btn btn-outline-primary" type="submit">Sort</button>
          </div>

          </form>
          
        </div>
      </section>
    <div class="container">
  
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

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
 

$conn = OpenCon();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if( isset($_POST['sortkey']) ){
    if($_POST["sortkey"]==1){
      $sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = '$creator_id' ORDER BY priority DESC";
    }elseif ($_POST["sortkey"]==2){
      $sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = '$creator_id' ORDER BY priority ASC";
    }elseif ($_POST["sortkey"]==3){
      $sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = '$creator_id' AND status=0";  
    }elseif ($_POST["sortkey"]==4){
      $sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = '$creator_id' AND status=1";  
    }else{
      $sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = '$creator_id'";
    }
  }else{
    $sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = '$creator_id'";
  }
}else {
  $sql = "SELECT todo_id, title, description, status, date_created, deadline, last_updated, priority FROM Todo WHERE creator_id = '$creator_id'";

}



$result = $conn->query($sql);
 
if($result->num_rows > 0)
{
    //output data of each row
    //create an array
    $rows = array();
    //fill that array
    while($row = $result->fetch_assoc())
    {
        $rows[] = $row;
      ?>
            <div class="col">
              <div class="card shadow-sm <?php echo ($row["status"] == 0 ? "card-pending" : "card-completed") ?>">
                
                <div class="card-body">
                  <ul class="list-unstyled mt-3 mb-4">
                    <li><b>Title: </b> <?php echo $row["title"]; ?></li>
                    <li><b>Description: </b> <?php echo $row["description"]; ?></li>
                    <li><b>Date Created: </b><?php echo $row["date_created"]; ?></li>
                    <li><b>Deadline: </b><?php echo $row["deadline"]; ?></li>

                    <li><b>Priority: </b><?php echo $row["priority"]; ?></li>
                  </ul>
                  
                  <p class="card-text"><b>Status: <?php echo ($row["status"] == 1 ? "Completed" : "Incomplete"); ?></b></p>
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <form method="POST">
                        <button type="submit" class="btn btn-sm btn-outline-secondary" formaction="delete_todo.php?todo=<?php echo $row["todo_id"]; ?>">Delete</button>
                        <button type="submit" class="btn btn-sm btn-outline-secondary" formaction="edit_todo.php?todo=<?php echo $row["todo_id"]; ?>">Edit</button>
                      </form>
                    </div>
                    <small class="text-muted"><?php echo $row["last_updated"]; ?></small>
                  </div>
                </div>
              </div>
            </div>

            <?php

    }
  
}

?>
  </div>
<?php
  include "footer.php";
?>