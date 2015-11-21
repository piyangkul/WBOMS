﻿<?php
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'product';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}

require_once 'function/func_product.php';
$val_idproduct = $_GET['idproduct']; //ส่งค่าpara
$getProductDetail = getProductDetail($val_idproduct);
$getProductUnit = getProductUnit($val_idproduct);
//echo "<pre>";
//print_r($getProductDetail);
//echo "</pre>";
$val_code_product = $getProductDetail['code_product'];
$val_name_product = $getProductDetail['name_product'];
$val_name_factoryID = $getProductDetail['idfactory'];
$val_name_factory = $getProductDetail['name_factory'];
$val_difference_amount_product = $getProductDetail['difference_amount_product'];
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
                            <h2>Edit Product</h2>   
                            <h5>แก้ไขสินค้า </h5>

                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group col-xs-12">
                                <div class="col-md-12 col-sm-12 ">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <label>สินค้า</label>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive ">
                                                <form class="form">
                                                    <div class="form-group col-xs-12">
                                                        <label for="productCode">รหัสสินค้า</label>
                                                        <input type="text" class="form-control" id="productCode" name="productCode" value="<?php echo $val_code_product; ?>">
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="productName"> ชื่อสินค้า </label>
                                                        <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $val_name_product; ?>">
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="factoryName"> ชื่อโรงงาน </label>
                                                        <select class="form-control" id="factoryName" name="factoryName" >
                                                            <option selected>Choose</option>
                                                            <?php
                                                            require_once '../interface_factory/function/func_factory.php';
                                                            $getFactorys = getFactorys();
                                                            foreach ($getFactorys as $value) {
                                                                $val_idfactory = $value['idfactory'];
                                                                $val_name_factory = $value['name_factory'];
                                                                ?>
                                                                <option <?php echo $val_idfactory == $val_name_factoryID ? "selected" : "" ?> value="<?php echo $val_idfactory; ?>"><?php echo $val_name_factory; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <a href="popup_add_product_unit.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1">
                                            <span class="glyphicon glyphicon-plus"></span> เพิ่มหน่วยสินค้า
                                        </a>
                                        <br/><br/>
                                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>จำนวนต่อหน่วยใหญ่</th>
                                                    <th>หน่วยใหญ่</th>
                                                    <th>จำนวนต่อหน่วยรอง</th>
                                                    <th>หน่วยรอง</th>
                                                    <th>การกระทำ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($getProductUnit as $value) {
                                                    if ($value['name_big'] == NULL) {
                                                        continue;
                                                    }
                                                    $valUnit = $value['name'];
                                                    $valAmount = $value['amount_unit'];
                                                    $valBigUnit = $value['name_big'];
                                                    ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><?php echo $valUnit; ?></td>
                                                        <td><?php echo $valAmount; ?></td>
                                                        <td><?php echo $valBigUnit; ?></td>
                                                        <td> 
                                                            <!-- Button trigger modal -->
                                                            <a href="popup_edit_product_unit.php" class="btn btn-warning" data-toggle="modal" data-target="#myModal2" data-toggle="tooltip" title="แก้ไข">
                                                                <span class="glyphicon glyphicon-edit"></span> 
                                                            </a>
                                                            <a href="popup_delete_product_unit.php" class="btn btn-danger" data-toggle="modal" data-target="#myModal3" data-toggle="tooltip" title="ลบ">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                        </table>
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
                                        <form class="form">
                                            <div class="form-group col-xs-12">
                                                <label for="disabledInput1">หน่วยใหญ่ที่สุด</label>
                                                <input type="text" class="form-control" id="disabledInput1" placeholder="มัด" disabled>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="exampleInputName4"> ราคาเปิดต่อหน่วยใหญ่ที่สุด </label>
                                                <input type="text" class="form-control" id="exampleInputName4" placeholder="560">
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <div class="col-md-12 col-sm-12 ">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <label>ต้นทุนลด</label>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="table-responsive ">
                                                                <form class="form">
                                                                    <label class="radio">
                                                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ต้นทุนลดเปอร์เซ็นต์
                                                                            <input type="text" class="form-control" placeholder="กรอก%ต้นทุนลด" id="userName" name="username" value="" /> 
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ต้นทุนสุทธิไม่ลด
                                                                    </label>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="exampleInputName2"> ราคาต้นทุน </label>
                                                <input type="text" class="form-control" id="exampleInputName2" placeholder="504">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End ราคาสินค้า -->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <a href="product.php" class="btn btn-info btn-lg text-center">
                                <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                            </a>
                            <a href="#" class="btn btn-danger btn-lg text-center">
                                <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                            </a>
                        </div>
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
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/js/custom.js"></script>


    </body>
</html>
<!-- Modalเพิ่มหน่วย -->
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
<!-- Modalแก้ไขหน่วย -->
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
<!-- Modalลบหน่วย -->
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