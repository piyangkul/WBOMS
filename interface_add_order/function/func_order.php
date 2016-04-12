<?php
require_once dirname(__FILE__) . '/../../config/connect.php';
function getOrder() {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_p.idorder_p,code_order_p,shop.idshop,shop.name_shop,date_order_p,time_order_p,detail_order_p,factory.difference_amount_factory,COUNT(product_order.idproduct_order) AS count_product ,SUM(product_order.price_product_order*product_order.amount_product_order) AS price_product_order,concat(concat(`region`.`code_region`,`province`.`code_province`),`shop`.`idshop`,code_order_p) AS code FROM order_p INNER JOIN shop ON shop.idshop = order_p.idshop INNER JOIN product_order ON order_p.idorder_p = product_order.idorder_p INNER JOIN unit ON unit.idunit = product_order.idunit INNER JOIN product ON product.idproduct = unit.idproduct  INNER JOIN factory ON factory.idfactory = product.idfactory INNER JOIN province ON shop.idprovince = province.idprovince INNER JOIN region ON province.idregion = region.idregion GROUP BY order_p.idorder_p";
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

