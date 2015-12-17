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
                                        echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addPeriodError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>';
                                    } else if ($_GET['action'] == "editPeriodCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editPeriodError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>';
                                    }
                                }
                                ?>
                            </span>
                            <div class="alert alert-success" role="alert">
                                <b>หมายเหตุ</b> ถ้ามีการเพิ่มข้อมูลการจ่ายเงินโรงงานแล้ว จะแก้ไขรอบการส่งไม่ได้ --> ตัดบิลแล้วกลับมาแก้รอบไม่ได้
                            </div>
                            <!-- ตารางรอบการส่งสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h5>ตารางรอบการส่งสินค้า</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">รอบที่</div></th>
                                                    <th><div align="center">วันเริ่มต้น</div></th>
                                                    <th><div align="center">วันสิ้นสุด</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //ดึงข้อมูลจากตาราง
                                                require_once 'function/func_shipment.php';
                                                $getShipment_period = getShipment_period();
                                                $i = 0;
                                                foreach ($getShipment_period as $value) {
                                                    $i++;
                                                    $val_idshipment_period = $value['idshipment_period'];
                                                    $val_date_start = $value['date_start'];
                                                    $change_date_start = date("d-m-Y", strtotime($val_date_start));
                                                    $val_date_end = $value['date_end'];
                                                    $change_date_end = date("d-m-Y", strtotime($val_date_end));
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $change_date_start; ?></td>
                                                        <td><?php echo $change_date_end; ?></td>
                                                        <td>
                                                            <a href="shipment2.php?idshipment_period=<?php echo $val_idshipment_period; ?>" class="btn btn-success" title="รายละเอียด">
                                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                            </a>
                                                            <a href="popup_edit_period_shipment.php?idshipment_period=<?php echo $val_idshipment_period; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" title="แก้ไข">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>  
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
            });
        </script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
        </script>
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