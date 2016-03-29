<?php
require_once 'function/func_stat.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'stat';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>THIP WAREE Project</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- MORRIS CHART STYLES-->
        <link href="../assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="../assets/css/custom.css" rel="stylesheet" />
        <!--        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
                <script src="//code.jquery.com/jquery-1.10.2.js"></script>
                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->

    </head>
    <body>
        <div id="wrapper">
            <!--  NAV TOP  -->
            <?php include '../interface_template/template_nav_top.php'; ?>  

            <!--  NAV SIDE  -->
            <?php include '../interface_template/template_nav_side.php'; ?>  
            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2> Statistic Finance </h2>   
                            <h5> สถิติการเงิน </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">                          
                            <a href="chart.php" class="btn btn-warning btn-lg">
                                <span class="fa fa-line-chart"></span> Chart
                            </a>
                            <br/>
                            <br/>
                            <!-- ข้อมูลการเงินรายเดือน-ปี -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางข้อมูลการเงินรายเดือน-ปี</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
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
                                                //ดึงข้อมูลจากตาราง

                                                $getIncome_Outcome = getIncome_Outcome();
                                                $var_arr_des_by_indxB = subval_sort($getIncome_Outcome, "date_start", "DES"); //กลับลำดับ
                                                $num = sizeof($var_arr_des_by_indxB); //ลำดับของรอบ โดยหาขนาดของarray
                                                //$i = 0;
                                                foreach ($var_arr_des_by_indxB as $value) {
                                                    //$i++;
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
                                                        <td class="text-right"><?php echo number_format($val_income, 2); ?></td>
                                                        <?php if ($val_outcome == NULL) { ?>
                                                            <td class="text-right"><?php echo "รอเพิ่มข้อมูล"; ?></td>
                                                        <?php } else { ?> 
                                                            <td class="text-right"><?php echo number_format($val_outcome, 2); ?></td>
                                                        <?php } ?>
                                                        <?php if ($profit > 0) { ?>
                                                            <td class="text-right"><?php echo number_format($profit, 2); ?></td>
                                                        <?php } else { ?> 
                                                            <td class="text-right" style="color: red"><?php echo number_format($profit, 2); ?></td>
                                                        <?php } ?> 
                                                    </tr>

                                                    <?php
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
                                    </div>
                                </div>
                            </div>
                            <!-- End ข้อมูลการเงินรายเดือน-ปี -->
                        </div>
                    </div>
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. WRAPPER  -->
        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>

        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable({"sort": false});
            });
        </script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal');
            });
        </script>

    </body>
</html>
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
<!--<div class="alert alert-danger" role="alert">1.รง.ไทยฟูดส์เพี้ยน </div>-->