<?php
/* require_once 'controller/connection.php'; */
require_once 'controller/checkPermission.php';
require_once 'controller/cAssignment.php';
require_once 'controller/cPopup.php';

$checkPermission = new checkPermission();

if($checkPermission->isLogin() != 1) {
    header('Location: login');
}

echo file_get_contents('views/header.php');
?>
<header><title>Assignment</title></header>
<?php if (isset($_GET['successful'])):
    if ($_GET['successful'] == 1) {
        $popUp = Popup::oneButton("Upload", "The file has been uploaded!");
    } elseif ($_GET['successful'] == 2) {
        $popUp = Popup::oneButton("Upload", "There was an error uploading this file!");
    }
endif;
if ($checkPermission->isTeacher() == 1): ?>
 <!-- TODO: Teacher's Assignment Management -->
<div class="container">
    <div class="row"> 
        <div class="col-md">
            <div style="margin: 50px auto;">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <form action="controller/upload.php" method="POST" enctype= "multipart/form-data">
                            <div class="form-group">
                                <h2 class="text-center">Upload Assignment</h2>  
                                <input type="text" name="uploadAssignment" value="1" hidden>
                                <div class="form-group">
                                    <input type="text" class="form-control-file" name="assName" placeholder="Assignment Name" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" name="assUpload" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Upload</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div style="margin: 50px auto;">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="form-group"><br>
                            <h2 class="text-center">Assignment Management</h2><br>
                            <a href="submitted">
                                <button type="submit" class="btn btn-success btn-block">Student's Assignment</button> 
                            </a>
                            <br>
                            <a href="view_assignment">
                                <button type="submit" class="btn btn-success btn-block">Given Assignment</button> 
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
else:
    $assGiven = Assignment::getAssignment();
?>
<div class="upload-form">
    <div class="card shadow-lg">
        <div class="card-body p-5">
            <form action="controller/upload.php" method="POST" enctype= "multipart/form-data">
                <div class="form-group">
                    <h2 class="text-center">Answer</h2>
                    <div class="form-group">
                        <select class="form-control" name="assName" required>
                            <?php foreach ($assGiven as $ass): ?>
                                <option value='<?php echo $ass->getAssID(); ?>'><?php echo htmlspecialchars($ass->getAssName(), ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="assUpload" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Upload</button> 
                </div>
            </form>
            <a href="view_assignment">
            <button type="submit" class="btn btn-success btn-block">Given Assignment</button>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container">
  <div class="vertical-center">
        <a href="./">
            <button type="submit" class="btn btn-success btn-block">Back to Dashboard</button>              
        </a>
  </div>
</div>

<?php echo file_get_contents ("views/footer.php"); ?>