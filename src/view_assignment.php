<?php
require_once 'controller/cAssignment.php';
require_once 'controller/checkPermission.php';
require_once 'controller/cPopup.php';
$checkPermission = new checkPermission();

if ($checkPermission->isLogin() != 1) {
    header('Location: login');
}

echo file_get_contents('views/header.php');
if (isset($_GET['successful'])) {
    if ($_GET['successful'] == 1) {
        $popUp = Popup::oneButton("Student List", "Remove assignment successfully");
    } elseif ($_GET['successful'] == 2) {
        $popUp = Popup::oneButton("Student List", "Remove assignment not successfully");
    }
}
?>
<header>
    <title>View Assignment</title>
</header>
<div class="table-form">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">File</th>
                <?php if ($checkPermission->isTeacher() == 1) : ?>
                    <th scope="col" class="text-center"></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            $assGiven = Assignment::getAssignment();
            foreach ($assGiven as $ass) :
            ?>
                <tr>
                    <th scope='row' class="text-center"><?php echo $count += 1; ?></th>
                    <td class="text-center"><?php echo htmlspecialchars(html_entity_decode($ass->getAssName()), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-center"><a href=<?php echo $ass->getAssFile(); ?> target="_blank" rel="noopener noreferrer"><button class="btn btn-outline-success">View</button></a></td>
                    <?php if ($_SESSION['role'] == 1) : ?>
                        <td class="text-center"><a href="controller/remove.php?assID=<?php echo $ass->getAssID(); ?>"><button class="btn btn-outline-danger">Remove</button></a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
    <?php echo file_get_contents('views/footer.php'); ?>