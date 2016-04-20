<?php

require_once dirname(__FILE__) . '/../../config/connect.php';

function getOrder() {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_p.idorder_p,code_order_p,shop.idshop,shop.name_shop,date_order_p,time_order_p,detail_order_p,factory.difference_amount_factory,COUNT(product_order.idproduct_order) AS count_product ,SUM(product_order.price_product_order-product_order.price_product_order*(factory.difference_amount_factory/100)) AS price_product_order FROM order_p INNER JOIN shop ON shop.idshop = order_p.idshop INNER JOIN product_order ON order_p.idorder_p = product_order.idorder_p INNER JOIN unit ON unit.idunit = product_order.idunit INNER JOIN product ON product.idproduct = unit.idproduct  INNER JOIN factory ON factory.idfactory = product.idfactory GROUP BY order_p.idorder_p ORDER BY date_product_refunds DESC";
    $SQLPrepare = $conn->prepare($SQLCommand);
    $SQLPrepare->execute(
    );
    $resultArr = array();
    while ($result = $SQLPrepare->fetch(PDO::FETCH_ASSOC)) {
        array_push($resultArr, $result);
    }
    return $resultArr;
}

function getProductOrderRefunds() {
    $conn = dbconnect();
    $SQLCommand = "SELECT order_product_refunds.idorder_product_refunds,shop_idshop,shop.name_shop,date_product_refunds,order_product_refunds.order_price_product_refunds,COUNT(product_refunds.idproduct_refunds) AS idproduct_refunds FROM `order_product_refunds` INNER JOIN shop ON shop.idshop=order_product_refunds.shop_idshop INNER JOIN product_refunds ON product_refunds.order_product_refunds_idorder_product_refunds = order_product_refunds.idorder_product_refunds GROUP BY order_product_refunds.idorder_product_refunds ";
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

