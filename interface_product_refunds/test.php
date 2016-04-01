<?php

require_once dirname(__FILE__) . '/../config/connect.php';
    $conn = dbconnect();
    $SQLCommand = "SELECT idshop,name_shop FROM shop";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute();
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    print json_encode($resultArr, JSON_UNESCAPED_UNICODE);
    return "{}";
?>