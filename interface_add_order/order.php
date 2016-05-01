<?php
require_once 'function/func_order.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_order';
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
        <!-- GOOGLE FONTS-->
        <link href='../http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                            <h2> Order </h2>   
                            <h5> คำสั่งซื้อ </h5>

                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <a href="action/action_reset.php?cancel=addorder" class="btn btn-info btn-lg">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มคำสั่งซื้อ
                            </a>
                            <br/><br/>
                            <?php
                            if (isset($_GET['action'])) {
                                if ($_GET['action'] == "addCompleted") {
                                    echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>';
                                } else if ($_GET['action'] == "addError") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>';
                                } else if ($_GET['action'] == "editCompleted") {
                                    echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>';
                                } else if ($_GET['action'] == "editError") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>';
                                } else if ($_GET['action'] == "delCompleted") {
                                    echo '<center><h4 class="text-success">คุณได้ทำการลบสำเร็จแล้ว</h4></center>';
                                } else if ($_GET['action'] == "delError") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถลบได้ มีสินค้าที่ถูกจัดส่งหรือถูกเลื่อนไปรอบถัดไป</h4></center>';
                                } else if ($_GET['action'] == "addErrorDuplicateCode") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้เนื่องจากรหัสสินค้าซ้ำ</h4></center>';
                                } else if ($_GET['action'] == "delProductdError") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถลบได้เนื่องจากมีคำสั่งซื้ออยู่</h4></center>';
                                } else if ($_GET['action'] == "addErrorDuplicateProduct") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้เนื่องจากคุณได้เพิ่มชื่อสินค้าสินค้าไปแล้ว</h4></center>';
                                } else if ($_GET['action'] == "addErrorNotHaveProduct") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้เนื่องจากคุณไม่ได้กรอกสินค้า</h4></center>';
                                }
                            }
                            ?>

                            <!-- ตารางประวัติคำสั่งซื้อ -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    ประวัติคำสั่งซื้อ
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <center>
                                                        <th><center>ลำดับ</center></th>
                                                        <th><center>รหัสใบคำสั่งซื้อ</center></th>
                                                        <th><center>วันที่สั่งซื้อ</center></th>
                                                        <th><center>เวลาสั่งซื้อ</center></th>
                                                        <th><center>ชื่อร้านค้า</center></th>
                                                        <th><center>จำนวนรายการสินค้า</center></th>
                                                        <th><center>ราคาขายรวมต่อบิล</center></th>
                                                        <th><center>การกระทำ</center></th>
                                                    </center>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getOrder = getOrder();
                                                $i = 0;
                                                foreach ($getOrder as $value) {
                                                    $i++;
                                                    $val_idorder_p = $value['idorder_p'];
                                                    $val_code_order_p = $value['code'];
                                                    $val_date_order_p = $value['date_order_p'];
                                                    $date_for =  date_create($val_date_order_p);
                                                    $date_for->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                                    $val_time_order_p = $value['time_order_p'];
                                                    $val_name_shop = $value['name_shop'];
                                                    $val_count_product = $value['count_product'];
                                                    $val_price_product_order = $value['price_product_order'];
                                                    $getPrice_percent = getPricePercent($val_idorder_p);
                                                    $price_percent = $getPrice_percent['price_percent'];
                                                    $getPrice_bath = getPriceBath($val_idorder_p);
                                                    $price_bath = 0; //$getPrice_bath['price_bath'];
                                                    foreach ($getPrice_bath as $value) {
                                                        $idproduct = $value['idproduct'];
                                                        $idunit = $value['idunit'];
                                                        $price = $value['price_product_order'];
                                                        $amount_product_order = $value['amount_product_order'];
                                                        $difference_product_order = $value['difference_product_order'];
                                                        $amount = 1;
                                                        $getDiff = getDiffBathactionOrder($idproduct, $idunit);
                                                        foreach ($getDiff as $value) {
                                                            $val_amount_unit = $value['amount_unit'];
                                                            $val_price = $value['price_unit'];
                                                            $amount = $val_amount_unit * $amount;
                                                        }
                                                        $price_bath += ($price * $amount_product_order)+($difference_product_order*$amount_product_order);
                                                    }
                                                    //$getPrice_bath['price_bath'];
                                                    //$val_count_idproduct_order = $value['count_idproduct_order'];
                                                    ?>
                                                    <tr>
                                                        <td class ="text-center"><?php echo $i; ?></td>
                                                        <td class ="text-center"><?php echo $val_code_order_p; ?></td>
                                                        <td class ="text-center"><?php echo date_format($date_for,'d-m-Y'); ?></td>
                                                        <td class ="text-center"><?php echo $val_time_order_p; ?></td>
                                                        <td class ="text-center"><?php echo $val_name_shop; ?></td>
                                                        <td class ="text-center"><?php echo $val_count_product; ?></td>
                                                        <td class ="text-right"><?php echo number_format($price_percent + $price_bath, 2); ?></td>
                                                        <td> <center>

                                                                <a href="detail_order.php?idorder=<?php echo $val_idorder_p; ?>" class="btn btn-success" data-toggle="tooltip" title="รายละเอียด">
                                                                    <span class="glyphicon glyphicon-list-alt"></span>
                                                                </a>
                                                                <a href="edit_order.php?idorder=<?php echo $val_idorder_p; ?>" class="btn btn-warning " data-toggle="tooltip" title="แก้ไข">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>
                                                                <a onclick="return confirm('คุณต้องการลบหรือไม่')" href="action/action_delOrder.php?idorder=<?php echo $val_idorder_p; ?>" class="btn btn-danger">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--End Advanced Tables -->
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
                                                                    $('#dataTables-example').dataTable();
                                                                });
        </script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/js/custom.js"></script>


    </body>
</html>
<!-- Modalรายละเอียด -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modalแก้ไข -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modalลบ -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>