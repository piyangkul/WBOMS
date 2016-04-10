<?php

require_once dirname(__FILE__) . '/../function/func_factory.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";
//กลุ่มรับค่า
//ส่งข้อมูล หน้า add factory มาหน้านี้ 
$code_factory = $_POST['code_factory'];
$name_factory = $_POST['name_factory'];
$tel_factory = $_POST['tel_factory'];
$address_factory = $_POST['address_factory'];
$contact_factory = $_POST['contact_factory'];
$difference_amount_factory;
$detail_factory = $_POST['detail_factory'];
$type_factory = $_POST['type'];
if ($type_factory === 'PERCENT') {
    $difference_amount_factory = $_POST['difference_amount_factory'];
} elseif ($type_factory === 'BATH') {
    $difference_amount_factory = 0;
}
echo $type_factory;
//สิ้นสุดกลุ่มรับค่า
//
//กลุ่มคำสั่งทำอะไร
if (!checkDuplicateFactory($name_factory)) {
    $idfactory = addFactory($code_factory, $name_factory, $tel_factory, $address_factory, $contact_factory, $difference_amount_factory, $detail_factory, $type_factory);
    if ($idfactory > 0) {
        header("location: ../factory.php?p=factory&action=addFactoryCompleted");
    } else {
        header("location: ../factory.php?p=factory&action=addFactoryError");
    }
} else {
    header("location: ../factory.php?p=factory&action=addFactoryDuplicateError");
}
//สิ้นสุดกลุ่มคำสั่งทำอะไร