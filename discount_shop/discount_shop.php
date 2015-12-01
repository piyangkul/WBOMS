<?php
require_once 'function/func_discount_shop.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'discount_shop';
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
                            <h2> Discount Shop </h2>   
                            <h5> ส่วนลดร้านค้า </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <span>
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
                            }
                        }
                        ?>
                    </span>
                    <!-- ค้นหา -->
                    <div class="row">
                        <div class="col-md-3"></div>                        
                        <div class="col-md-6 "> 
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <div class="table-responsive">
                                        <div class="form-group">
                                            <label for="code_product">รหัสสินค้า</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-circle-o-notch" ></i></span>
                                                <input type="text" class="form-control" name="code_product" placeholder="กรอกรหัสสินค้า" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name_product">ชื่อสินค้า</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                                                <select class="form-control" id="idproduct" name="idproduct" onchange="getDiscount_product();">
                                                    <option selected value="">Choose</option>
                                                    <?php
                                                    require_once '../interface_product/function/func_product.php';
                                                    $getProducts = getProducts();
                                                    foreach ($getProducts as $value) {
                                                        if ($value['idunit_big'] != NULL) {
                                                            continue;
                                                        }
                                                        $val_idproduct = $value['idproduct'];
                                                        $val_name_product = $value['name_product'];
                                                        ?>
                                                        <option value="<?php echo $val_idproduct; ?>"><?php echo $val_name_product; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" align="center">
                                            <a href="popup_add_discount_shop.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                                <span class="glyphicon glyphicon-search"></span> ค้นหา
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End ค้นหา -->
                    <br/>
                    <!-- ข้อมูลต้นทุนสินค้า -->
                    <div class="row">
                        <div class="col-md-3"></div>                        
                        <div class="col-md-6 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>ข้อมูลต้นทุนสินค้า</label>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_Discount_product_table">
                                        <!-- table -->


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End ข้อมูลต้นทุนสินค้า -->
                    <br/>
                    <!-- ส่วนลดร้านค้า -->
                    <div class="row">
                        <div class="col-md-2"></div>                        
                        <div class="col-md-8 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>ส่วนลดร้านค้า</label>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">ร้านค้า</div></th>
                                                    <th><div align="center">ขายลด</div></th>
                                                    <th><div align="center">ราคาขาย</div></th>
                                                    <th><div align="center">วันที่อัพเดทล่าสุด</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
//                                                $getShops = getShops();
                                                $i = 0;
                                                foreach ($getShops as $value) {
                                                    $i++;
                                                    $val_name_shop = $value['name_shop'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_name_shop; ?></td>
                                                        <td>8%</td>
                                                        <td>515.20</td>
                                                        <td>2015-11-5</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End ส่วนลดร้านค้า -->

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
                $('[data-toggle="tooltip"]').tooltip();
            });

            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal');
            });
            
            function getDiscount_product() {
                var idproduct = $("#idproduct").val();
                $.get("action/action_discount_shop_show.php?idproduct=" + idproduct, function (data, status) {
                    $("#show_Discount_product_table").html(data);
                });
            }
        </script>
        <!-- CUSTOM SCRIPTS -->
        <!--<script src="../assets/js/custom.js"></script>-->
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