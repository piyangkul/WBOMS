<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getDiscountByID($idproduct) {
    $conn = dbconnect();
    $SQLCommand = "SELECT "
            . "`idproduct`, "
            . "`idunit`, "
            . "`name`, "
            . "`idunit_big`, "
            . "`name_big`, "
            . "`price_unit`, "
            . "`amount_unit`, "
            . "`type_unit` "
            . "`difference_amount_product` "
            . "FROM `view_product` "
            . "WHERE `idproduct`=:idproduct";
    echo $SQLCommand;
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
            array(
                ":idproduct" => $idproduct
            )
    );
    $result = $SQLPrepare->fetch(PDO::FETCH_ASSOC);
    return $result;
}