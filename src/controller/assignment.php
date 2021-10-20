<?php
require_once 'connection.php';
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
echo file_get_contents('../views/header.html');
echo "<header><title>Assignment</title></header>";
if ($_SESSION['role'] == 1): ?>
 <!-- TODO: Teacher's Assignment Management -->
<div class="row"> 
    <div class="col-md">
        <div class="upload-form">
            <form class="form" action="upload.php" method="POST" enctype= "multipart/form-data">
                <div class="form-group">
                    <h2 class="text-center">Upload Assignment</h2>  
                    <input type="text" name="uploadAssignment" value="1" hidden>
                    <div class="form-group">
                        <input type="text" class="form-control-file" name="assName" placeholder="Assignment Name" required="required">
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="assUpload" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Upload</button> 
                </div>
            </form>
        </div>
    </div>
    <div class="col-md">
        <div class="upload-form">
            <div class="form">
                <div class="form-group"><br>
                    <h2 class="text-center">Assignment Management</h2><br>
                    <a href="submitted.php">
                        <button type="submit" class="btn btn-primary btn-block">Student's Assignment</button> 
                    </a>
                    <br>
                    <a href="view_assignment.php">
                        <button type="submit" class="btn btn-primary btn-block">My Assignment</button> 
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
else:  /* TODO: Student's Assigment Management */
    $query = "SELECT assID, assName FROM assignment";
    $result = mysqli_query($con, $query);
?>
<div class="upload-form">
    <div class="form">
        <form action="upload.php" method="POST" enctype= "multipart/form-data">
            <div class="form-group">
                <h2 class="text-center">Answer</h2>
                <div class="form-group">
                    <select class="form-control" name="assName" required>
                        <?php while($row1 = mysqli_fetch_array($result)) echo "<option value='$row1[0]'>$row1[1]</option>"; ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control-file" name="assUpload" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Upload</button> 
            </div>
        </form>
        <a href="view_assignment.php">
        <button type="submit" class="btn btn-primary btn-block">View Assignment</button>
        </a>
    </div>
</div>
<?php endif; ?>

<div class="container">
  <div class="vertical-center">
        <form action="../">
            <button type="submit" class="btn btn-primary btn-block">Back to Dashboard</button>              
        </form>
  </div>
</div>

<?php echo file_get_contents ("../views/footer.html"); ?>