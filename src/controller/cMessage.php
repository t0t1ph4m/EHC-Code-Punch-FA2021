<?php use Message as GlobalMessage;

require_once 'connect.php';

class Message {
    private $messID;/*  */
    private $fromID;
    private $toID;
    private $content;

    public function __construct($messID, $fromID, $toID, $content) {
        $this->messID = $messID;
        $this->fromID = $fromID;
        $this->toID = $toID;
        $this->content = $content;
    }

    function getMessID() {
        return $this->messID;
    }

    function getFromID() {
        return $this->fromID;
    }
    
    function setMessID($messID) {
        $this->messID = $messID;
    }
    
    function setFromID($fromID) {
        $this->fromID = $fromID;
    }

    function getToID() {
        return $this->toID;
    }

    function setToID($toID) {
        $this->toID = $toID;
    }

    function getContent() {
        return $this->content;
    }

    function setContent($content) {
        $this->content = $content;
    }

    public static function insertToDB ($fromID, $toID, $content) {
        $messID = (int) ($fromID . $toID);
        $conn = dbConnect::ConnectToDB();

        //TODO: Check if account is available
        $check = $conn->prepare("SELECT COUNT(*) FROM account WHERE id=? OR id=?");
        $check->execute(array(
            $fromID,
            $toID
        ));

        $row = $check->fetch();
        if ($row['COUNT(*)'] == 0) {
            return false;
        }

        if ($stmt = $conn->prepare("REPLACE INTO messagebox (messID, fromID, toID, content) VALUES (?, ?, ?, ?)")) {
            $res = $stmt->execute(array(
                $messID,
                $fromID,
                $toID,
                $content
            ));
        } else {
            return false;
        }
        $conn = null;
        return $res;
    }

    public static function getMessage($fromID, $toID) {
        $messID =  (int) ($fromID . $toID);
        $conn = dbConnect::ConnectToDB();
        $stmt = $conn->prepare("SELECT COUNT(*), * FROM messagebox WHERE messID=?");
        $stmt->execute(array(
            $messID
        ));
        $row = $stmt->fetch();
        if ($row['COUNT(*)'] > 0) {
            return new GlobalMessage($row['messID'], $row['fromID'], $row['toID'], $row['content']);
        }
        $conn = null;
        return null;
    }

    public static function removeMessage ($fromID, $toID) {
        $messID = (int) ($fromID . $toID);
        $conn = dbConnect::ConnectToDB();
        $stmt = $conn->prepare("DELETE FROM messagebox WHERE messID = ?");
        $res = $stmt->execute(array(
            $messID
        ));
        return $res;
    }

    public static function fetchUser ($toID) {
        $res = array();
        $conn = dbConnect::ConnectToDB();
        $stmt = $conn->prepare("SELECT fromID FROM messagebox WHERE toID = ?");
        $stmt->execute(array(
            $toID
        ));
        while ($row = $stmt->fetchObject()) {
            array_push($res, $row->fromID);
        }
        return $res;
    }
} ?>
