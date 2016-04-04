<?php
require_once 'function/func_stat.php';
$year_start = $_GET['year_start'];
$month_start = $_GET['month_start'];
$year_end = $_GET['year_end'];
$get_month_end = $_GET['get_month_end'];
?>
<option value="">เลือกเดือนสิ้นสุด</option>
<?php
if ($year_end == $year_start) {
    $getMonth_end = getMonth_end($month_start);
    foreach ($getMonth_end as $value) {
        $val_month_end = $value['month_end'];
        if ($val_month_end == 1) {
            $name_month = "มกราคม";
        } elseif ($val_month_end == 2) {
            $name_month = "กุมภาพันธ์";
        } elseif ($val_month_end == 3) {
            $name_month = "มีนาคม";
        } elseif ($val_month_end == 4) {
            $name_month = "เมษายน";
        } elseif ($val_month_end == 5) {
            $name_month = "พฤษภาคม";
        } elseif ($val_month_end == 6) {
            $name_month = "มิถุนายน";
        } elseif ($val_month_end == 7) {
            $name_month = "กรกฎาคม";
        } elseif ($val_month_end == 8) {
            $name_month = "สิงหาคม";
        } elseif ($val_month_end == 9) {
            $name_month = "กันยายน";
        } elseif ($val_month_end == 10) {
            $name_month = "ตุลาคม";
        } elseif ($val_month_end == 11) {
            $name_month = "พฤศจิกายน";
        } else {
            $name_month = "ธันวาคม";
        }
        ?>
        <option value="<?php echo $val_month_end; ?>" <?php if ($val_month_end == $get_month_end) { ?> selected <?php } ?> ><?php echo "เดือน: $val_month_end $name_month "; ?></option>
    <?php } ?>

    <?php
} else {
    $getMonth_end = getMonth_endThisYear();
    foreach ($getMonth_end as $value) {
        $val_month_end = $value['month_end'];
        if ($val_month_end == 1) {
            $name_month = "มกราคม";
        } elseif ($val_month_end == 2) {
            $name_month = "กุมภาพันธ์";
        } elseif ($val_month_end == 3) {
            $name_month = "มีนาคม";
        } elseif ($val_month_end == 4) {
            $name_month = "เมษายน";
        } elseif ($val_month_end == 5) {
            $name_month = "พฤษภาคม";
        } elseif ($val_month_end == 6) {
            $name_month = "มิถุนายน";
        } elseif ($val_month_end == 7) {
            $name_month = "กรกฎาคม";
        } elseif ($val_month_end == 8) {
            $name_month = "สิงหาคม";
        } elseif ($val_month_end == 9) {
            $name_month = "กันยายน";
        } elseif ($val_month_end == 10) {
            $name_month = "ตุลาคม";
        } elseif ($val_month_end == 11) {
            $name_month = "พฤศจิกายน";
        } else {
            $name_month = "ธันวาคม";
        }
        ?>
        <option value="<?php echo $val_month_end; ?>" <?php if ($val_month_end == $get_month_end) { ?> selected <?php } ?> ><?php echo "เดือน: $val_month_end $name_month "; ?></option>
    <?php }
}
?>