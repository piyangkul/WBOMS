<?php
require_once 'function/func_shipment.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'shipment';
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
                            <h2> Shipment </h2>   
                            <h5> การส่งสินค้า </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <a href="popup_add_period_shipment.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มรอบการส่งสินค้า
                            </a>
                            <br/>
                            <br/>
                            <span>
                                <?php
                                if (isset($_GET['action'])) {
                                    if ($_GET['action'] == "addPeriodCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มรอบการส่งสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addPeriodError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มรอบการส่งสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "editPeriodCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขรอบการส่งสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editPeriodError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขรอบการส่งสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "delPeriodCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการลบรอบการส่งสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "delPeriodError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถลบรอบการส่งสินค้าได้</h4></center>';
                                    }
                                }
                                ?>
                            </span>
                            <div class="alert alert-success" role="alert">
                                <b>หมายเหตุ</b> ในแต่ละรอบ เมื่อมีการเพิ่มข้อมูลการส่งสินค้าแล้ว จะไม่สามารถแก้ไขและลบรอบการส่งได้ --> มีการส่งแล้วกลับมาแก้,ลบรอบการส่งไม่ได้
                                <br>แก้ไขได้เฉพาะวันสิ้นสุดเท่านั้น <br>ลบได้เฉพาะรอบสุดท้ายเท่านั้น <br>แก้ไขวันสิ้นสุดแล้ววันเริ่มต้นของรอบถัดไปจะแก้ตาม
                                            </div>
                                            <!--<h4 class="alert alert-danger" role="alert">1.ลำดับรอบยอมรับได้ไหม</h4>-->
                                            <!-- ตารางรอบการส่งสินค้า -->
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    <h4>ตารางรอบการส่งสินค้า</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                                            <thead>
                                                                <tr>
                                                                    <th><div align="center">รอบที่</div></th>
                                                                    <th><div align="center">วันเริ่มต้น</div></th>
                                                                    <th><div align="center">วันสิ้นสุด</div></th>
                                                                    <th><div align="center">จำนวนโรงงานที่ยังทำไม่เสร็จ/ทั้งหมด</div></th>
                                                                    <th><div align="center">การกระทำ</div></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                //ดึงข้อมูลจากตาราง
                                                                require_once 'function/func_shipment.php';
                                                                $getShipment_period = getShipment_period();
                                                                $var_arr_des_by_indxB = subval_sort($getShipment_period, "date_start", "DES"); //กลับลำดับ
                                                                //print_r($var_arr_des_by_indxB);
                                                                $getLastidShipment = getLastidShipment();
                                                                $val_last_idshipment_period = $getLastidShipment['idshipment_period'];
                                                                $num = sizeof($var_arr_des_by_indxB); //ลำดับของรอบ โดยหาขนาดของarray
                                                                foreach ($var_arr_des_by_indxB as $value) {
                                                                    $val_last_idshipment_period;
                                                                    $val_idshipment_period = $value['idshipment_period'];
                                                                    $val_date_start = $value['date_start'];
                                                                    $date_start = date_create($val_date_start);
                                                                    $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                                    $val_date_end = $value['date_end'];
                                                                    $date_end = date_create($val_date_end);
                                                                    $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                                    $count_notFinish = $value['count_notFinish'] != NULL ? $value['count_notFinish'] : "-";
                                                                    $Total2 = $value['Total2'];
                                                                    ?>
                                                                    <?php // print_r(end($getShipment_period)['idshipment_period']) ; ?>
                                                                    <?php //print_r($var_arr_des_by_indxB) ; ?>
                                                                    <tr>
                                                                        <td><?php echo $num--; ?></td><!--ลำดับของรอบ-->
                                                                        <td><?php echo date_format($date_start, 'd-m-Y'); ?></td>
                                                                        <td><?php echo date_format($date_end, 'd-m-Y'); ?></td>
    <!--                                                                        <td><?php //echo $count_notFinish."/".$Total2;   ?> </td>-->
                                                                        <td><?php echo get_numFactory_notFinish($val_idshipment_period) . "/" . get_numAllFactory_shipment1($val_idshipment_period); ?> </td>
                                                                        <td align="left">
                                                                            <a href="shipment2.php?idshipment_period=<?php echo $val_idshipment_period; ?>" class="btn btn-success" title="รายละเอียด">
                                                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                                            </a>
                                                                            <?php
                                                                            $getCountCheckByIDshipment_period = getCountCheckByIDshipment_period($val_idshipment_period);
                                                                            foreach ($getCountCheckByIDshipment_period as $value) {
                                                                                $val_idorder_transport = $value['idorder_transport'];
                                                                            }
                                                                            ?>
                                                                            <?php if ($val_idorder_transport == NULL) { ?> <!--ถ้าไม่มีข้อมูลให้แสดง-->
                                                                                <a href="popup_edit_period_shipment.php?idshipment_period=<?php echo $val_idshipment_period; ?>&idNextshipment=<?php echo $val_idshipment_period + 1; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" title="แก้ไข">
                                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                                </a>
                                                                                <?php if ($val_idshipment_period == end($getShipment_period)['idshipment_period']) { ?> <!-- เป็นรอบบนสุดไหม-->
                                                                                    <a href="action/action_delPeriod_shipment.php?idshipment_period=<?php echo $val_idshipment_period; ?>" onclick="if (!confirm('คุณต้องการลบรอบการส่งสินค้าหรือไม่')) {
                                                                                                return false;
                                                                                            }" class="btn btn-danger " title="ลบ">
                                                                                        <span class="glyphicon glyphicon-trash"></span>
                                                                                    </a>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $val_last_idshipment_period--;
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
                                            <!--End ตารางรอบการส่งสินค้า -->
                                            </div>
                                            </div>

                                            <!-- /. PAGE INNER  -->
                                            </div>
                                            <!-- /. PAGE WRAPPER  -->
                                            </div>
                                            </div>
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
                                                                            function getmonth() {
                                                                                var date_start = $("#date_start").val();
                                                                                var datearr_start = date_start.split("-");
                                                                                var date_end = $("#date_end").val();
                                                                                var datearr_end = date_end.split("-");
                                                                                //                    alert(datearr_start[1] + " " + datearr_end[1]);
                                                                                var optionhtml = '<option selected value="">Choose</option><option value="' + datearr_start[1] + '">' + datearr_start[1] + '</option><option value="' + datearr_end[1] + '">' + datearr_end[1] + '</option>';
                                                                                $("#monthly").html(optionhtml);
                                                                            }
                                            </script>
                                            <script>
                                                $(function () {
                                                    $('[data-toggle="tooltip"]').tooltip();
                                                });</script>
                                            <script>
                                                $(document).ready(function () {
                                                    $('#dataTables-example').dataTable({"sort": false});
                                                });</script>
                                            <script>
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