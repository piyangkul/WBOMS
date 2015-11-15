<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function addMember($name, $lastname, $username, $password, $status_member) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `member`(`name`, `lastname`, `username`, `password`, `status_member`) "
            . "VALUES (:name, :lastname, :username, :password, :status_member)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name" => $name,
                ":lastname" => $lastname,
                ":username" => $username,
                ":password" => $password,
                ":status_member" => $status_member
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function editMember($name, $lastname, $username, $password, $status_member, $idmember) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `member` SET "
            . "`name`=:name,"
            . "`lastname`=:lastname,"
            . "`username`=:username,"
            . "`password`=:password,"
            . "`status_member`=:status_member "
            . "WHERE `idmember`=:idmember";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name" => $name,
                ":lastname" => $lastname,
                ":username" => $username,
                ":password" => $password,
                ":status_member" => $status_member,
                ":idmember" => $idmember
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function delMember($idmember) {
    $conn = dbconnect();
    $SQLCommand = "DELETE FROM `member` WHERE `idmember`=:idmember";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idmember" => $idmember
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return TRUE;
    } else {
        return false;
    }
}

function getMembers() {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idmember`, `name`, `lastname`, `username`, `password`, `status_member` FROM `member`";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();

    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getMemberByID($idmember) {
    $conn = dbconnect();
    $SQLCommand = "SELECT `idmember`, "
            . "`name`, "
            . "`lastname`, "
            . "`username`, "
            . "`password`, "
            . "`status_member` "
            . "FROM `member` "
            . "WHERE `idmember`=:idmember ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idmember" => $idmember,
            )
    );

       $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function add($p1, $p2, $p3) {
    $conn = dbconnect();
    $SQLCommand = "";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                "p1" => $p1,
                "p2" => $p2,
                "p3" => $p3
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}
