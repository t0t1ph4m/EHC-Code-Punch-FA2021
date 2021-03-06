<?php
require_once 'checkPermission.php';
require_once 'cUser.php';
require_once 'cAssignment.php';
require_once 'cGame.php';

$checkPermission = new checkPermission();

if($checkPermission->isLogin() != 1) {
    header('Location: ../login');
}

if ($checkPermission->isTeacher() != 1) {
    echo "<script>alert('You are not allowed to access this page!'); window.location = '../index.php';</script>";
    exit;
}

if (isset($_GET["studentID"])) {
    if($remove = User::removeUser($_GET["studentID"])) {
        /* echo "<script>alert('Remove student successfully'); window.location = '../studentInfo.php';</script>"; */
        header('Location: ../student?successful=1');
    } else {
        header('Location: ../student?successful=2');
    }
} else if (isset($_GET["assID"])) {
    if (unlink('../' . Assignment::fetchAssFile($_GET["assID"])) && $remove = Assignment::removeAss($_GET["assID"])) {
        $ans = Assignment::fetchAssAnsFile($_GET["assID"]);
        unlink ('../' . $ans);
        header('Location: ../view_assignment?successful=1');
    } else {
        header('Location: ../view_assignment?successful=2');
    }
} else if (isset($_GET["challenge"]) and ($_GET["challenge"] == 1)) {
    if (unlink('../' . Game::fetchGameFile()) && $remove = Game::removeChall()) {
        header('Location: ../challenge?removesuccessful=1');
    } else {
        header('Location: ../challenge?removesuccessful=2');
    }
} else {
    header('Location: ../index');
    exit;
}
