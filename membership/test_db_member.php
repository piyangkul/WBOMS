<?php
require_once 'connect.php';

function editUser($user, $pass, $name, $surname, $id) {
    global $con;
    reconnect();
    $query = "UPDATE `project`.`member` SET `name` = '$name', `lastname` = '$surname', `username` = '$user', `password` = '$pass' WHERE `member`.`idmember` = $id";
    $res = $con->query($query);
    return $res;
}

function getUser($id) {
    $a = $id;
    global $con;
    reconnect();
    if ($res = $con->query("SELECT * FROM member where idmember=$a")) {
        $arrResult = array();
        $user = $res->fetch(PDO::FETCH_OBJ);
        return array("name" => $user->name, "lastname" => $user->lastname, "user" => $user->username, "pass" => $user->password, "id" => $user->idmember);
    } else
        return false;
}

function delUser($id) {
    global $con;
    reconnect();
    $query = "DELETE FROM `project`.`member` WHERE `member`.`idmember` = $id";
    $res = $con->query($query);
    return $res;
}

function addUser($user, $pass, $name, $surname) {
    global $con;
    reconnect();
    $query = "INSERT INTO `project`.`member` (`idmember`, `name`, `lastname`, `username`, `password`) VALUES (NULL, '$name', '$surname', '$user', '$pass', '$type')";
    $res = $con->query($query);
    return $res;
}

?>
