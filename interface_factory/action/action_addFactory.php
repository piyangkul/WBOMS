<?php

require_once dirname(__FILE__) . '/../function/func_factory.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";
//กลุ่มรับค่า
//ส่งข้อมูล หน้า add factory มาหน้านี้ 
$name_factory = $_POST['name_factory'];
$tel_factory = $_POST['tel_factory'];
$address_factory = $_POST['address_factory'];
$contact_factory = $_POST['contact_factory'];
$difference_amount_factory = $_POST['difference_amount_factory'];
$detail_factory = $_POST['detail_factory'];
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
$idfactory = addFactory($name_factory, $tel_factory, $address_factory, $contact_factory, $difference_amount_factory, $detail_factory);
if ($idfactory > 0) {
    header("location: ../factory.php?p=factory&action=addCompleted");
} else {
    header("location: ../factory.php?p=factory&action=addError");
}
//สิ้นสุดกลุ่มคำสั่งทำอะไร