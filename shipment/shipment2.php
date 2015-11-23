<?php
require_once 'function/func_shipment.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'shipment';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
$name_factory = $_POST['factoryName'];
$monthly = $_POST['monthly'];
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
                            <center><h4>บิลของโรงงาน <?php echo $name_factory; ?> &nbsp;&nbsp;&nbsp;&nbsp; ประจำเดือน <?php echo $monthly; ?></h4></center>
                            <a href="popup_add_shipment.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่ม/อัพเดทข้อมูลการส่งสินค้า
                            </a>

                            <br/>
                            <span>
                                <?php
                                if (isset($_GET['action'])) {
                                    if ($_GET['action'] == "addCompleted") {
                                        echo "<center><h4>คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>";
                                    } else if ($_GET['action'] == "addError") {
                                        echo "<center><h4>ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>";
                                    } else if ($_GET['action'] == "editCompleted") {
                                        echo "<center><h4>คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>";
                                    } else if ($_GET['action'] == "editError") {
                                        echo "<center><h4>ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>";
                                    } else if ($_GET['action'] == "delCompleted") {
                                        echo "<center><h4>คุณได้ทำการลบสำเร็จแล้ว</h4></center>";
                                    } else if ($_GET['action'] == "delError") {
                                        echo "<center><h4>ผิดพลาด!! ไม่สามารถลบได้</h4></center>";
                                    }
                                }
                                ?>
                            </span>
                            <h5>คำชี้แจง : ตรวจสอบรายการสินค้าที่สั่งซื้อและเพิ่มข้อมูลการส่งสินค้า</h5>
                            <h5>หมายเหตุ : เมื่อเพิ่มข้อมูลการส่งสินค้าแล้ว คุณจะไม่สามารถแก้ไข หรือลบจำนวนสินค้าได้ เพราะเมื่อกดเพิ่มแล้ว ปุ่มแก้ไขและลบจะหายไป</h5>
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
                                                    <th rowspan="2" valign="middle"><div align="center">เลือก</div></th>
                                                    <th rowspan="2"><div align="center">วันที่สั่ง</div></th>
                                                    <th rowspan="2"><div align="center">ร้านค้า</div></th>
                                                    <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                                    <th rowspan="2"><div align="center">ราคาเปิดต่อหน่วย</div></th>
                                                    <th rowspan="2"><div align="center">จำนวน</div></th>
                                                    <th colspan="3"><div align="center">ข้อมูลการส่งสินค้า</div></th>
                                                    <th rowspan="2"><div align="center">การกระทำ</div></th>
                                                </tr>
                                                <tr>
                                                    <th><div align="center">วันที่ส่ง</div></th>
                                                    <th><div align="center">ชื่อ/เล่มที่/เลขที่</div></th>
                                                    <th><div align="center">ค่าส่ง</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getShops = getShop();
                                                $i = 0;
                                                foreach ($getShops as $value) {
                                                    $i++;
                                                    $val_idshop = $value['idshop'];
                                                    $val_name_shop = $value['name_shop'];
                                                    $val_tel_shop = $value['tel_shop'];
                                                    $val_name_region = $value['name_region'];
                                                    $val_name_province = $value['name_province'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_name_shop; ?></td>
                                                        <td><?php echo $val_tel_shop; ?></td>
                                                        <td><?php echo $val_name_region; ?></td>
                                                        <td><?php echo $val_name_province; ?></td>
                                                        <td>
                                                            <a href="popup_detail_shipment.php?idshop=<?php echo $val_idshop; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="รายละเอียด">
                                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                            </a>
                                                            <a href="popup_edit_amount_product_order.php?idshop=<?php echo $val_idshop; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </a>
                                                            <a href="action/action_delShop.php?idshop=<?php echo $val_idshop; ?>" onclick="if (!confirm('คุณต้องการลบหรือไม่')) {
                                                                        return false;
                                                                    }" class="btn btn-danger " title="ลบ">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?> 

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