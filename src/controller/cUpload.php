<?php
require_once 'connect.php';

class Upload {
    public function __construct() {
        
    }

    public static function uploadAssignment($assName, $target_file) {
        $conn = dbConnect::ConnectToDB();
        $target_file = substr($target_file, 3);
        $assName = htmlentities($assName, ENT_QUOTES, 'UTF-8');
        if ($stmt = $conn -> prepare ("INSERT INTO assignment (assName, assFile) VALUES (?, ?)")) {
            $res = $stmt->execute(array(
                $assName,
                $target_file
            ));
            return $res;
        } else {
            return 0;
        }
        $conn = null;
    }

    public static function uploadGame($target_file, $hint) {
        $conn = dbConnect::ConnectToDB();
        $target_file = substr($target_file, 3);
        $check = $conn->query("SELECT COUNT(*) FROM game");
        $row = $check->fetch();
        if ($row['COUNT(*)'] > 0) {
            return 2;
        }

        if ($stmt = $conn -> prepare ("REPLACE INTO game (challID, gameFile, hint) VALUES (1, ?, ?)")) {
            $res = $stmt->execute(array(
                $target_file,
                $hint
            ));
            return $res ? 1:0;
        } else {
            return 0;
        }
        $conn = null;
    }

    public static function assAnswer($assID, $target_file, $id) {
        $conn = dbConnect::ConnectToDB();
        $checkAss = $conn->prepare("SELECT COUNT(*) FROM assignment WHERE assID=?");
        $checkAss->execute(array(
            $assID
        ));
        $row = $checkAss->fetch();
        if ($row['COUNT(*)'] == 0) {
            return 0;
        }
        $target_file = substr($target_file, 3);
        if ($sql = $conn -> prepare ("INSERT INTO answerass (assID, assAnswer, id) VALUES (?, ?, ?)")) {
            $res = $sql->execute(array(
                $assID,
                $target_file,
                $id
            ));
            return $res;
        } else {
            return 0;
        }
        $conn = null;
    }
}
