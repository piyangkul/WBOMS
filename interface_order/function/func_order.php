<?php
require_once dirname(__FILE__) . '/../../config/connect.php';
function getOrder() {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_p.idorder_p,shop.idshop,shop.name_shop,date_order_p,time_order_p,detail_order_p,status_order_p,COUNT(idproduct_order) AS count_idproduct_order FROM order_p INNER JOIN shop ON shop.idshop = order_p.idshop INNER JOIN product_order ON order_p.idorder_p = product_order.idorder_p ";

    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

