<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function checkDuplicateMember($name,$lastname) {
    $conn = dbconnect();
    $SQLCommand = "SELECT * FROM `member` WHERE `name`LIKE :name AND `lastname` LIKE :lastname ";

    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name" => $name,
                ":lastname" => $lastname
            )
    );
    if ($SQLPrepare->rowCount() > 0) {
        return 1;
    } else {
        return 0;
    }
}

function addMember($name, $lastname, $username, $password) {
    $conn = dbconnect();
    $SQLCommand = "INSERT INTO `member`(`name`, `lastname`, `username`, `password`) "
            . "VALUES (:name, :lastname, :username, :password)";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name" => $name,
                ":lastname" => $lastname,
                ":username" => $username,
                ":password" => $password
            )
    );

    if ($SQLPrepare->rowCount() > 0) {
        return $conn->lastInsertId();
    } else {
        return false;
    }
}

function editMember($name, $lastname, $password, $idmember) {
    $conn = dbconnect();
    $SQLCommand = "UPDATE `member` SET `name`=:name,`lastname`=:lastname,`password`=:password WHERE `idmember`=:idmember";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":name" => $name,
                ":lastname" => $lastname,
                ":password" => $password,
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
    $SQLCommand = "SELECT `idmember`, `name`, `lastname`, `username`, `password` FROM `member`";

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
            . "`password` "
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
