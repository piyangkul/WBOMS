<?php
session_start();
if (!isset($_SESSION['username']))
    header('Location: ../index.php');

$p = 'product';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}

//echo "<pre>";
//print_r($_POST);
//print_r($_SESSION["unit"]);
//echo "</pre>";
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
                    <form action="action/action_addProduct.php" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Add Product</h2>
                                <h5>เพิ่มสินค้า </h5>
                            </div>
                        </div>
                        <!-- /. ROW  -->
                        <hr />
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 ">
                                <!-- บิล -->
                                <div class="panel panel-default">
                                    <div class="panel-heading ">
                                        <div class="table-responsive">
                                            <div>
                                                <label for="exampleInputName1">รหัสสินค้า</label>
                                                <input type="text" class="form-control" id="productID" name="productID" placeholder="กรอกรหัสสินค้า" >
                                            </div>
                                            <br/>
                                            <div>
                                                <label for="exampleInputName2"> ชื่อสินค้า </label>
                                                <input type="text" class="form-control" id="productName" name="productName" placeholder="กรอกชื่อสินค้า">
                                            </div>
                                            <br/>
                                            <div>
                                                <label for="exampleInputName3"> ชื่อโรงงาน </label>
                                                <input type="text" class="form-control" id="factoryName" name="factoryName" placeholder="กรอกชื่อโรงงาน">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End บิล -->
                            </div>
                        </div>

                        <!-- หน่วยสินค้า -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12 ">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label>หน่วยสินค้า</label>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <a href="popup_add_product_unit.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                                <span class="glyphicon glyphicon-plus"></span> เพิ่มหน่วยสินค้า
                                            </a>
                                            <br/><br/>
                                            <div id="showUnit"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End หน่วยสินค้า -->

                        <!-- ราคาสินค้า -->
                        <div class="row ">
                            <div class="col-md-3"></div>
                            <div class="col-md-5 col-sm-5 ">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <label>ราคาสินค้า</label>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive ">
                                            <div class="form-group col-xs-12">
                                                <label for="bigestUnit">หน่วยใหญ่ที่สุด</label>
                                                <input type="text" class="form-control" id="bigestUnit" value="" disabled>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="bigestPrice"> ราคาเปิดต่อหน่วยใหญ่ที่สุด </label>
                                                <input type="text" class="form-control" id="bigestPrice" readonly>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="difference_amount">ต้นทุนลดเป็น% (%ที่โรงงานลดให้เรา)//ลด10%</label>
                                                <input type="text" class="form-control" id="difference_amount" name="difference_amount" placeholder="0" value="0" required="" onchange="calBigestPrice();">
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="bigestPriceResult"> ดังนั้นราคาต้นทุนต่อหน่วยใหญ่สุด//ระบบคำนวณอัตโนมัติ </label>
                                                <input type="text" class="form-control" id="bigestPriceResult" name="bigestPriceResult">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End ราคาสินค้า -->
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <button type="submit" class="btn btn-info btn-lg text-center">
                                    <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                                </button>
                                <a href="product.php" class="btn btn-danger btn-lg text-center">
                                    <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
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
                                                    });</script>
        <script>
            showUnit();
            function showUnit() {
                $.get("action_addUnit.php?p=showUnit", function (data, status) {
                    $("#showUnit").html(data);
                });
            }

            getBigestUnit();
            function getBigestUnit() {
                $.get("action_addUnit.php?p=getBigestUnit", function (data, status) {
                    if (data != "-1") {
                        $("#bigestUnit").val(data);
                    }
                    else {
                        $("#bigestUnit").val("n/a");
                    }
                });
            }

            getBigestPrice();
            function getBigestPrice() {
                $.get("action_addUnit.php?p=getBigestPrice", function (data, status) {
                    if (data != "-1") {
                        $("#bigestPrice").val(data);
                    }
                    else {
                        $("#bigestPrice").val("0");
                    }
                });
            }

            function calBigestPrice() {
                var difference_amount = $("#difference_amount").val();
                var bigestPrice = $("#bigestPrice").val();
                var total = bigestPrice - (bigestPrice * (difference_amount / 100.0));
                $("#bigestPriceResult").val(total);
            }
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