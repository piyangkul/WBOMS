<?php
require_once dirname(__FILE__) . '/../function/func_stat.php';

?>
<table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
    <thead>
        <tr>
            <th><div align="center">รอบที่</div></th>
<th><div align="center">วันที่เริ่มรอบ</div></th>
<th><div align="center">วันที่สิ้นสุดรอบ</div></th>                                         
<th><div align="center">รายได้จากร้านค้า</div></th>
<th><div align="center">รายจ่ายของโรงงาน</div></th>
<th><div align="center">กำไร/ขาดทุน</div></th>
</tr>
</thead>
<tbody>
    <?php
    if (isset($_GET['year_start'])) {
        $year_start = $_GET['year_start']; //2015
        $month_start = $_GET['month_start'];
        $year_end = $_GET['year_end'];
        $month_end = $_GET['month_end'];
        //ดึงข้อมูลจากตาราง
        $getIncome_Outcome = getIncome_Outcome($month_start, $year_start, $month_end, $year_end);
        if ($getIncome_Outcome != NULL) {
            $var_arr_des_by_indxB = subval_sort($getIncome_Outcome, "date_start", "DES"); //กลับลำดับ
            $num = sizeof($var_arr_des_by_indxB); //ลำดับของรอบ โดยหาขนาดของarray
            //$i = 0;
            foreach ($var_arr_des_by_indxB as $value) {
                //$i++;
                $val_idshipment_period = $value['idshipment_period'];
                $val_date_start = $value['date_start'];
                $date_start = date_create($val_date_start);
                $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
                $val_date_end = $value['date_end'];
                $date_end = date_create($val_date_end);
                $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
                $val_income = $value['income'];
                $val_outcome = $value['outcome'];
                $profit = $val_income - $val_outcome;
                ?>
                <tr>
                    <td><?php echo $num--; ?></td>                            
                    <td><?php echo date_format($date_start, 'd-m-Y'); ?></td>
                    <td><?php echo date_format($date_end, 'd-m-Y'); ?></td>

                    <?php if ($val_income == NULL) { ?>
                        <td class="text-right"><?php echo "รอเพิ่มข้อมูล"; ?></td>
                    <?php } else { ?> 
                        <td class="text-right">
                            <?php echo "<a href='popup_stat_income.php?idshipment_period=$val_idshipment_period' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_income, 2) . " </a>"; ?>
                        </td>
                    <?php } ?>

                    <?php if ($val_outcome == NULL) { ?>
                        <td class="text-right"><?php echo "รอเพิ่มข้อมูล"; ?></td>
                    <?php } else { ?> 
                        <td class="text-right">
                            <?php echo "<a href='popup_stat_outcome.php?idshipment_period=$val_idshipment_period' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_outcome, 2) . " </a>"; ?>
                        </td>
                    <?php } ?>

                    <?php if ($profit >= 0) { ?>
                        <td class="text-right"><?php echo number_format($profit, 2); ?></td>
                    <?php } else { ?> 
                        <td class="text-right" style="color: red"><?php echo number_format($profit, 2); ?></td>
                    <?php } ?> 
                </tr>
                <?php
            }
        } else {
            
        }
    }
    if (isset($_GET['get_year_start'])) {
        $year_start = $_GET['get_year_start'];
        $month_start = $_GET['get_month_start'];
        $year_end = $_GET['get_year_end'];
        $month_end = $_GET['get_month_end'];
        //ดึงข้อมูลจากตาราง
        $getIncome_Outcome = getIncome_Outcome($month_start, $year_start, $month_end, $year_end);
        if ($getIncome_Outcome != NULL) {
            $var_arr_des_by_indxB = subval_sort($getIncome_Outcome, "date_start", "DES"); //กลับลำดับ
            $num = sizeof($var_arr_des_by_indxB); //ลำดับของรอบ โดยหาขนาดของarray
            //$i = 0;
            foreach ($var_arr_des_by_indxB as $value) {
                //$i++;
                $val_idshipment_period = $value['idshipment_period'];
                $val_date_start = $value['date_start'];
                $date_start = date_create($val_date_start);
                $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
                $val_date_end = $value['date_end'];
                $date_end = date_create($val_date_end);
                $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
                $val_income = $value['income'];
                $val_outcome = $value['outcome'];
                $profit = $val_income - $val_outcome;
                ?>
                <tr>
                    <td><?php echo $num--; ?></td>                            
                    <td><?php echo date_format($date_start, 'd-m-Y'); ?></td>
                    <td><?php echo date_format($date_end, 'd-m-Y'); ?></td>

                    <?php if ($val_income == NULL) { ?>
                        <td class="text-right"><?php echo "รอเพิ่มข้อมูล"; ?></td>
                    <?php } else { ?> 
                        <td class="text-right">
                            <?php echo "<a href='popup_stat_income.php?idshipment_period=$val_idshipment_period' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_income, 2) . " </a>"; ?>
                        </td>
                    <?php } ?>

                    <?php if ($val_outcome == NULL) { ?>
                        <td class="text-right"><?php echo "รอเพิ่มข้อมูล"; ?></td>
                    <?php } else { ?> 
                        <td class="text-right">
                            <?php echo "<a href='popup_stat_outcome.php?idshipment_period=$val_idshipment_period' data-toggle='modal' data-target='#myModal-lg'> " . number_format($val_outcome, 2) . " </a>"; ?>
                        </td>
                    <?php } ?>

                    <?php if ($profit >= 0) { ?>
                        <td class="text-right"><?php echo number_format($profit, 2); ?></td>
                    <?php } else { ?> 
                        <td class="text-right" style="color: red"><?php echo number_format($profit, 2); ?></td>
                    <?php } ?> 
                </tr>
                <?php
            }
        } else {
            
        }
    }
    ?>
    <?php

    function subval_sort($a, $subkey, $sort_by) {
        foreach ($a as $k => $v) {
            $b[$k] = strtolower($v[$subkey]);
        }
        if ($sort_by == "ASC")
            asort($b);
        else if ($sort_by == "DES")
            arsort($b);
        else
            return false;

        foreach ($b as $key => $val) {
            $c[] = $a[$key];
        }
        return $c;
    }
    ?>
</tbody>
</table>
<script>
    $(document.body).on('hidden.bs.modal', function () {
        $('#myModal-lg').removeData('bs.modal');
    });
</script>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>
<div class="modal fade" id="myModal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content -->
        </div>
    </div>
</div>