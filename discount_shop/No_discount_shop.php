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
                            <h5> ประวัติส่วนลดร้านค้าล่าสุด </h5>
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
                                            <label for="product_code">ค้นหารหัสหรือชื่อสินค้า</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                                                <input type="text" class="form-control" id="searchProduct" name="searchProduct" onkeyup="searchProduct()" placeholder="กรอกชื่อสินค้า" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name_product">สินค้า</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                                                <select class="form-control" id="idproduct" name="idproduct" onchange="show_cost_product_table()">
                                                    <!--getProduct-->
                                                </select>
                                            </div>
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
                                    <div class="table-responsive" id="show_cost_product_table">
                                        <!-- show_cost_product_table -->
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
                                    <div class="table-responsive" id="show_discount_shop_table">
                                        <!-- show_discount_shop_table -->
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
            show_cost_product_table();
            function show_cost_product_table() {
                var idproduct = $("#idproduct").val();
                $.get("action/action_cost_product_show.php?idproduct=" + idproduct, function (data, status) {
                    $("#show_cost_product_table").html(data);
                    show_discount_shop_table();
                });
            }


            function show_discount_shop_table() {
                var idproduct = $("#idproduct").val();
                $.get("action/action_discount_shop_show.php?idproduct=" + idproduct, function (data, status) {
                    $("#show_discount_shop_table").html(data);
                });
            }
            searchProduct();
            function searchProduct() {
                var searchProduct = $("#searchProduct").val();
                $.get("discount_shop_search_product.php?searchProduct=" + searchProduct, function (data, status) {
                    $("#idproduct").html(data);
                    show_cost_product_table();
                    show_discount_shop_table();
                });
            }

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