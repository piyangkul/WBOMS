<?php

require_once dirname(__FILE__) . '/../function/func_shipment.php';
echo '<pre>';
print_r($_POST);
echo '</pre>';

$idshipment_period = $_GET['idshipment_period'];
$date_start = $_POST['date_start'];
$date_end = $_POST['date_end'];

//$Nextid = $_GET['Nextid']; //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย ติดเรียกใช้อัพเดท
//$val_next_date_start = $Nextid['date_start'];
//$val_next_date_end = $Nextid['date_end'];
//$date1 = str_replace('-', '/', $val_next_date_start);
//$update_date_start = date('Y-m-d', strtotime($date1 . "+1 days"));

//เอา$date_end+1 เป็นวันเริ่มต้นของรอบถัดไป -- $date_start
$date1 = str_replace('-', '/', $date_end);
$update_date_start = date('Y-m-d', strtotime($date1 . "+1 days"));

$Nextid = getNextid($idshipment_period); //ได้ค่าidรอบถัดไป --> อัพเดทรอบนี้ด้วย
$val_next_idshipment_period = $Nextid['idshipment_period'];
$val_next_date_start = $Nextid['date_start'];
$val_next_date_end = $Nextid['date_end'];
//$date1 = str_replace('-', '/', $val_next_date_start);
//$update_date_start = date('Y-m-d', strtotime($date1 . "+1 days"));
echo '<pre>';
echo $val_next_idshipment_period+"ID";
echo $update_date_start;
echo $val_next_date_end;
echo '</pre>';
$checkEditShipment_Period = editShipment_period($idshipment_period, $date_start, $date_end);
$checkEditNextShipment_Period = editShipment_period($val_next_idshipment_period, $update_date_start, $val_next_date_end);//แก้ไขเฉพาะวันเริ่มต้น

if ($checkEditShipment_Period) {
    header("location: ../shipment1.php?action=editPeriodCompleted");
} else {
    header("location: ../shipment1.php?action=editPeriodError");
}
