<?php

require_once dirname(__FILE__) . '/../function/func_shop.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";
//กลุ่มรับค่า
//ส่งข้อมูล หน้า add factory มาหน้านี้ 
$name_shop = $_GET['idshop'];
$name_shop = $_POST['name_shop'];
$tel_shop = $_POST['tel_shop'];
$address_shop = $_POST['address_shop'];
$idprovince = $_POST['idprovince'];
$detail_shop = $_POST['detail_shop'];
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
$checkEdit = editShop($name_shop, $tel_shop, $address_shop, $idprovince, $detail_shop,idshop);
if ($idfactory > 0) {
    header("location: ../shop.php?p=shop&action=editCompleted");
} else {
    header("location: ../shop.php?p=shop&action=editError");
}
//สิ้นสุดกลุ่มคำสั่งทำอะไร
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
