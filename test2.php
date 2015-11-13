<?php
$p = 'add_order.php';
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
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- MORRIS CHART STYLES-->
        <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        <!-- Date Picker -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css"/>
        <script>
            $(function () {
                $("#datepicker").datepicker();
            });
        </script>
    </head>
    <body>
       <div id="wrapper">   
            <!--  NAV TOP  -->
            <?php include 'template_nav_top.php'; ?>  

            <!--  NAV SIDE  -->
            <?php include 'template_nav_side.php'; ?> 

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Add Order</h2>   
                            <h5>รับคำสั่งซื้อ </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-6 col-sm-6 ">
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
                                                        <label for="disabled_no">No.บิล</label>
                                                        <input type="text" class="form-control" id="disabled_no" placeholder="ID บิล" disabled>
                                                    </div>

                                                    <div class="form-group col-xs-12">
                                                        <p>วันที่สั่งซื้อ <input type="text" id="datepicker"></p>
                                                    </div>

                                                    <div class="form-group col-xs-12">
                                                        <label for="name_shop"> ชื่อร้านค้า </label>
                                                        <input type="text" class="form-control" id="name_shop" placeholder="กรอกชื่อสินค้า">
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="name_factory"> ชื่อโรงงาน </label>
                                                        <input type="text" class="form-control" id="name_factory" placeholder="กรอกชื่อโรงงาน">
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="name_product"> ชื่อสินค้า </label>
                                                        <input type="text" class="form-control" id="name_product" placeholder="กรอกชื่อสินค้า">
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="name_product"> หน่วย</label> &nbsp;
                                                        <!-- Single button -->
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                กรุณาเลือกหน่วย<span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="#">มัด</a></li>
                                                                <li><a href="#">กล่อง</a></li>
                                                                <li><a href="#">แพ็ค</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="amount_product">จำนวน</label>
                                                        <input type="text" class="form-control" id="name_product" placeholder="กรอกจำนวนสินค้า">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ราคาสินค้า -->
                        <div class="col-md-6 col-sm-6 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>ราคาสินค้า</label>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive ">
                                        <form class="form">
                                            <div class="form-group col-xs-12">
                                                <label for="disabled_price_unit">ราคาเปิดต่อหน่วย</label>
                                                <input type="text" class="form-control" id="disabled_price_unit" placeholder="560" disabled>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="disabled_cost_discounts_percent"> ต้นทุนลดเปอร์เซ็นต์ </label>
                                                <input type="text" class="form-control" id="disabled_cost_discounts_percent" placeholder="10" disabled>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="exampleInputName2"> ราคาต้นทุน </label>
                                                <input type="text" class="form-control" id="exampleInputName2" placeholder="560">
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <div class="col-md-12 col-sm-12 ">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <label>ส่วนต่างราคาขาย</label>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="table-responsive ">
                                                                <form class="form">
                                                                    <label class="radio">
                                                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ขายลดเปอร์เซ็นต์
                                                                            <input type="text" class="form-control" placeholder="ใส่%ขายลด" id="userName" name="username" value="" /> 
                                                                    </label>
                                                                    <label class="radio">
                                                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ขายเพิ่มสุทธิ
                                                                            <input type="text" class="form-control" placeholder="ใส่ราคาขายเพิ่มสุทธิ" id="userName" name="username" value="" /> 
                                                                    </label>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="exampleInputName2"> ราคาขาย </label>
                                                <input type="text" class="form-control" id="exampleInputName2" placeholder="560">
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
                            <a href="product.html" class="btn btn-info btn-lg text-center">
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
                                    
                                    <!-- /. WRAPPER  -->
                                    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
                                    <!-- JQUERY SCRIPTS -->
                                    <script src="assets/js/jquery-1.10.2.js"></script>
                                    <!-- BOOTSTRAP SCRIPTS -->
                                    <script src="assets/js/bootstrap.min.js"></script>
                                    <!-- METISMENU SCRIPTS -->
                                    <script src="assets/js/jquery.metisMenu.js"></script>
                                    <!-- CUSTOM SCRIPTS -->
                                    <script src="assets/js/custom.js"></script>


                                    </body>
                                    </html>


