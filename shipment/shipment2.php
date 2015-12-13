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
<?php
if (isset($_GET['idshipment_period'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $change_date_start = date("d-m-Y", strtotime($val_date_start));
    $val_date_end = $getShipment_period['date_end'];
    $change_date_end = date("d-m-Y", strtotime($val_date_end));
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
                            <div>
                                <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo $change_date_start; ?> ถึง <?php echo $change_date_end; ?></h4></center>
                            </div>
                            <br/>
                            <span>
                                <?php
//                                if (isset($_GET['action'])) {
//                                    if ($_GET['action'] == "addCompleted") {
//                                        echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>';
//                                    } else if ($_GET['action'] == "addError") {
//                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>';
//                                    } else if ($_GET['action'] == "editCompleted") {
//                                        echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>';
//                                    } else if ($_GET['action'] == "editError") {
//                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>';
//                                    } 
//                                }
                                ?>
                            </span>
                            <div class="alert alert-success" role="alert">
                                <h5><b>คำชี้แจง</b> : ตรวจสอบรายการสินค้าที่สั่งซื้อและเพิ่มข้อมูลการส่งสินค้า</h5>
                                <h5><b>หมายเหตุ</b> : เมื่อเพิ่มข้อมูลการส่งสินค้าแล้ว คุณจะไม่สามารถแก้ไข หรือลบจำนวนสินค้าได้ เพราะเมื่อกดเพิ่มแล้ว ปุ่มแก้ไขและลบจะหายไป</h5>
                            check vaild id shipment period
                            </div>
                            <!-- ตารางรายการสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางรายการสินค้า</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center " id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">โรงงาน</div></th>
                                                    <th><div align="center">จำนวนรายการที่สั่ง</div></th>
                                                    <th><div align="center">ยอดเงินรวมที่โรงงานเรียกเก็บ</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <?php
                                                //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
                                                $getFactoryByIDshipment_period = getFactoryByIDshipment_period2($idshipment_period);
                                                $i = 0;
                                                foreach ($getFactoryByIDshipment_period as $value) {
                                                    $i++;
                                                    $val_idshipment_period = $value['idshipment_period'];
                                                    $val_idfactory = $value['idfactory'];
                                                    $val_name_factory = $value['name_factory'];
                                                    $val_CountCheck = $value['CountCheck'];
                                                    if ($val_CountCheck == NULL) {
                                                        $val_CountCheck = "-";
                                                    }
                                                    $val_price = $value['price'];
                                                    if ($val_price == NULL) {
                                                        $val_price = "-";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_name_factory; ?></td>
                                                        <td><?php echo $val_CountCheck; ?></td>
                                                        <td><?php echo $val_price; ?></td>
                                                        <td>
                                                            <a href="detail_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory; ?>" class="btn btn-success " data-toggle="tooltip" title="รายละเอียด">
                                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                            </a>
                                                            <a href="add_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory; ?>" class="btn btn-info " data-toggle="tooltip" title="เพิ่ม">
                                                                <span class="glyphicon glyphicon-plus"></span>
                                                            </a>
                                                            <a href="edit_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory; ?>" class="btn btn-warning " data-toggle="tooltip" title="แก้ไข">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                }
                                                ?> 
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <!--End ตารางรายการสินค้า -->

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
        <script>
            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal');
            });
        </script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
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