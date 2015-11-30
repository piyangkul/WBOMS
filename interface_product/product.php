<?php 
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'product';
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
                            <h2> Product </h2>   
                            <h5> สินค้า </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />

                    <div class="row">
                        <div class="col-md-12">
                            <a href="add_product.php" class="btn btn-info btn-lg">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มสินค้า
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
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถลบได้</h4></center>';
                                } else if ($_GET['action'] == "addErrorDuplicateCode") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้เนื่องจากรหัสสินค้าซ้ำ</h4></center>';
                                } else if ($_GET['action'] == "delProductdError") {
                                    echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถลบได้เนื่องจากมีคำสั่งซื้ออยู่</h4></center>';
                                }                                
                            }
                            ?>
                            <!-- ตารางสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    ตารางสินค้า
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">รหัสสินค้า</div></th>
                                                    <th><div align="center">ชื่อสินค้า</div></th>
                                                    <th><div align="center">ชื่อโรงงาน</div></th>
                                                    <th><div align="center">หน่วยสินค้า</div></th>
                                                    <th><div align="center">ราคาเปิด</div></th>
                                                    <th><div align="center">ต้นทุนลด</div></th>
                                                    <th><div align="center">ราคาต้นทุน</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require_once 'function/func_product.php';
                                                $getProducts = getProducts();
                                                $i = 0;
                                                foreach ($getProducts as $value) {
                                                    if ($value['idunit_big'] != NULL) {
                                                        continue;
                                                    }
                                                    $i++;
                                                    $val_idproduct = $value['idproduct'];
                                                    $val_code_product = $value['code_product'];
                                                    $val_name_product = $value['name_product'];
                                                    $val_name_factory = $value['name_factory'];
                                                    $val_name = $value['name'];
                                                    $val_price_unit = $value['price_unit'];
                                                    if ($value['difference_amount_product'] == null) {
                                                        $val_difference_amount = $value['difference_amount_factory'];
                                                    } else {
                                                        $val_difference_amount = $value['difference_amount_product'];
                                                    }
                                                    $cost = $val_price_unit - (($val_difference_amount / 100.0) * $val_price_unit);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_code_product; ?></td>
                                                        <td><?php echo $val_name_product; ?></td>
                                                        <td><?php echo $val_name_factory; ?></td>
                                                        <td><?php echo $val_name; ?></td>
                                                        <td class="text-right"><?php echo number_format($val_price_unit, 2, '.', ''); ?></td>
                                                        <td><?php echo $val_difference_amount . "%"; ?></td>
                                                        <td class="text-right"><?php echo number_format($cost, 2, '.', '') ?></td>
                                                        <td> 
                                                            <a href="popup_product_detail.php?idproduct=<?php echo $val_idproduct; ?>" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                            </a>
                                                            <a href="edit_product.php?idproduct=<?php echo $val_idproduct; ?>" class="btn btn-warning " >
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </a>
                                                            <a onclick="return confirm('คุณต้องการลบหรือไม่')" href="action/action_delProduct.php?idproduct=<?php echo $val_idproduct; ?>" class="btn btn-danger">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
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
            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal')
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
<!--ส่งค่าไป2ตัว
<a href="popup_product_detail.php?idproduct=<?php echo $val_idproduct; ?>&p=<?php echo $val_idproduct; ?>" class="btn btn-success" data-toggle="modal" data-target="#myModal">
    <span class="glyphicon glyphicon-list-alt"></span>
</a>-->