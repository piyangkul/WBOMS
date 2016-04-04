<?php
require_once 'function/func_stat.php';
$get_month_start = $_GET['get_month_start'];
?>
<option value="">เลือกเดือนเริ่มต้น</option>
<?php
$getMonth_start = getMonth_start();
foreach ($getMonth_start as $value) {
    $val_month_start = $value['month_start'];
    if ($val_month_start == 1) {
        $name_month = "มกราคม";
    } elseif ($val_month_start == 2) {
        $name_month = "กุมภาพันธ์";
    } elseif ($val_month_start == 3) {
        $name_month = "มีนาคม";
    } elseif ($val_month_start == 4) {
        $name_month = "เมษายน";
    } elseif ($val_month_start == 5) {
        $name_month = "พฤษภาคม";
    } elseif ($val_month_start == 6) {
        $name_month = "มิถุนายน";
    } elseif ($val_month_start == 7) {
        $name_month = "กรกฎาคม";
    } elseif ($val_month_start == 8) {
        $name_month = "สิงหาคม";
    } elseif ($val_month_start == 9) {
        $name_month = "กันยายน";
    } elseif ($val_month_start == 10) {
        $name_month = "ตุลาคม";
    } elseif ($val_month_start == 11) {
        $name_month = "พฤศจิกายน";
    } else {
        $name_month = "ธันวาคม";
    }
    ?>
    <option value="<?php echo $val_month_start; ?>" <?php if ($val_month_start == $get_month_start) { ?> selected <?php } ?> ><?php echo "เดือน: $val_month_start $name_month "; ?></option>
<?php } ?>