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
    if ($month_start == 1) {
        ?>                   
        <option value="2" <?php if (2 == $get_month_end) { ?> selected <?php } ?> >เดือน: 2 กุมภาพันธ์</option>
        <option value="3" <?php if (3 == $get_month_end) { ?> selected <?php } ?> >เดือน: 3 มีนาคม</option>
        <option value="4" <?php if (4 == $get_month_end) { ?> selected <?php } ?> >เดือน: 4 เมษายน</option>
        <option value="5" <?php if (5 == $get_month_end) { ?> selected <?php } ?> >เดือน: 5 พฤษภาคม</option>
        <option value="6" <?php if (6 == $get_month_end) { ?> selected <?php } ?> >เดือน: 6 มิถุนายน</option>
        <option value="7" <?php if (7 == $get_month_end) { ?> selected <?php } ?> >เดือน: 7 กรกฎาคม</option>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 2) {
        ?>
        <option value="3" <?php if (3 == $get_month_end) { ?> selected <?php } ?> >เดือน: 3 มีนาคม</option>
        <option value="4" <?php if (4 == $get_month_end) { ?> selected <?php } ?> >เดือน: 4 เมษายน</option>
        <option value="5" <?php if (5 == $get_month_end) { ?> selected <?php } ?> >เดือน: 5 พฤษภาคม</option>
        <option value="6" <?php if (6 == $get_month_end) { ?> selected <?php } ?> >เดือน: 6 มิถุนายน</option>
        <option value="7" <?php if (7 == $get_month_end) { ?> selected <?php } ?> >เดือน: 7 กรกฎาคม</option>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 3) {
        ?>
        <option value="4" <?php if (4 == $get_month_end) { ?> selected <?php } ?> >เดือน: 4 เมษายน</option>
        <option value="5" <?php if (5 == $get_month_end) { ?> selected <?php } ?> >เดือน: 5 พฤษภาคม</option>
        <option value="6" <?php if (6 == $get_month_end) { ?> selected <?php } ?> >เดือน: 6 มิถุนายน</option>
        <option value="7" <?php if (7 == $get_month_end) { ?> selected <?php } ?> >เดือน: 7 กรกฎาคม</option>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 4) {
        ?>
        <option value="5" <?php if (5 == $get_month_end) { ?> selected <?php } ?> >เดือน: 5 พฤษภาคม</option>
        <option value="6" <?php if (6 == $get_month_end) { ?> selected <?php } ?> >เดือน: 6 มิถุนายน</option>
        <option value="7" <?php if (7 == $get_month_end) { ?> selected <?php } ?> >เดือน: 7 กรกฎาคม</option>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 5) {
        ?>
        <option value="6" <?php if (6 == $get_month_end) { ?> selected <?php } ?> >เดือน: 6 มิถุนายน</option>
        <option value="7" <?php if (7 == $get_month_end) { ?> selected <?php } ?> >เดือน: 7 กรกฎาคม</option>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 6) {
        ?>
        <option value="7" <?php if (7 == $get_month_end) { ?> selected <?php } ?> >เดือน: 7 กรกฎาคม</option>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 7) {
        ?>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 8) {
        ?>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 9) {
        ?>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 10) {
        ?>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    } elseif ($month_start == 11) {
        ?>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
        <?php
    }
//    $getMonth_end = getMonth_end($month_start);
//    foreach ($getMonth_end as $value) {
//        $val_month_end = $value['month_end'];
//        if ($val_month_end == 1) {
//            $name_month = "มกราคม";
//        } elseif ($val_month_end == 2) {
//            $name_month = "กุมภาพันธ์";
//        } elseif ($val_month_end == 3) {
//            $name_month = "มีนาคม";
//        } elseif ($val_month_end == 4) {
//            $name_month = "เมษายน";
//        } elseif ($val_month_end == 5) {
//            $name_month = "พฤษภาคม";
//        } elseif ($val_month_end == 6) {
//            $name_month = "มิถุนายน";
//        } elseif ($val_month_end == 7) {
//            $name_month = "กรกฎาคม";
//        } elseif ($val_month_end == 8) {
//            $name_month = "สิงหาคม";
//        } elseif ($val_month_end == 9) {
//            $name_month = "กันยายน";
//        } elseif ($val_month_end == 10) {
//            $name_month = "ตุลาคม";
//        } elseif ($val_month_end == 11) {
//            $name_month = "พฤศจิกายน";
//        } else {
//            $name_month = "ธันวาคม";
//        }
    ?>
    <!--<option value="<?php echo $val_month_end; ?>" <?php if ($val_month_end == $get_month_end) { ?> selected <?php } ?> ><?php echo "เดือน: $val_month_end $name_month "; ?></option>-->
    <?php // }    ?>

<?php } else { ?>       
        <option value="1" <?php if (1 == $get_month_end) { ?> selected <?php } ?> >เดือน: 1 มกราคม</option>
        <option value="2" <?php if (2 == $get_month_end) { ?> selected <?php } ?> >เดือน: 2 กุมภาพันธ์</option>
        <option value="3" <?php if (3 == $get_month_end) { ?> selected <?php } ?> >เดือน: 3 มีนาคม</option>
        <option value="4" <?php if (4 == $get_month_end) { ?> selected <?php } ?> >เดือน: 4 เมษายน</option>
        <option value="5" <?php if (5 == $get_month_end) { ?> selected <?php } ?> >เดือน: 5 พฤษภาคม</option>
        <option value="6" <?php if (6 == $get_month_end) { ?> selected <?php } ?> >เดือน: 6 มิถุนายน</option>
        <option value="7" <?php if (7 == $get_month_end) { ?> selected <?php } ?> >เดือน: 7 กรกฎาคม</option>
        <option value="8" <?php if (8 == $get_month_end) { ?> selected <?php } ?> >เดือน: 8 สิงหาคม</option>
        <option value="9" <?php if (9 == $get_month_end) { ?> selected <?php } ?> >เดือน: 9 กันยายน</option>
        <option value="10" <?php if (10 == $get_month_end) { ?> selected <?php } ?> >เดือน: 10 ตุลาคม</option>
        <option value="11" <?php if (11 == $get_month_end) { ?> selected <?php } ?> >เดือน: 11 พฤศจิกายน</option>
        <option value="12" <?php if (12 == $get_month_end) { ?> selected <?php } ?> >เดือน: 12 ธันวาคม</option>
    <?php
    
//    $getMonth_end = getMonth_endThisYear();
//    foreach ($getMonth_end as $value) {
//        $val_month_end = $value['month_end'];
//        if ($val_month_end == 1) {
//            $name_month = "มกราคม";
//        } elseif ($val_month_end == 2) {
//            $name_month = "กุมภาพันธ์";
//        } elseif ($val_month_end == 3) {
//            $name_month = "มีนาคม";
//        } elseif ($val_month_end == 4) {
//            $name_month = "เมษายน";
//        } elseif ($val_month_end == 5) {
//            $name_month = "พฤษภาคม";
//        } elseif ($val_month_end == 6) {
//            $name_month = "มิถุนายน";
//        } elseif ($val_month_end == 7) {
//            $name_month = "กรกฎาคม";
//        } elseif ($val_month_end == 8) {
//            $name_month = "สิงหาคม";
//        } elseif ($val_month_end == 9) {
//            $name_month = "กันยายน";
//        } elseif ($val_month_end == 10) {
//            $name_month = "ตุลาคม";
//        } elseif ($val_month_end == 11) {
//            $name_month = "พฤศจิกายน";
//        } else {
//            $name_month = "ธันวาคม";
//        }
    ?>
    <!--<option value="<?php echo $val_month_end; ?>" <?php if ($val_month_end == $get_month_end) { ?> selected <?php } ?> ><?php echo "เดือน: $val_month_end $name_month "; ?></option>-->
    <?php
    // }
}
?>