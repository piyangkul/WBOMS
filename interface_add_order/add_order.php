<?php
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
            <?php include '../interface_template/template_nav_top.php'; ?>  

            <!--  NAV SIDE  -->
            <?php include '../interface_template/template_nav_side.php'; ?>    

            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2> Add Order </h2>   
                            <h5> เพิ่มคำสั่งซื้อ </h5>

                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-5">
                            <!-- บิล -->
                            <div class="panel panel-default">

                                <div class="panel-heading ">
                                    <div class="table-responsive">
                                        <form class="form" id="LoginForm" method="post" action="warning.php">
                                            <form class="form">
                                                <div class="form-group">
                                                    <div>
                                                        <label for="disabled_no">No.บิล</label>
                                                        <input type="text" class="form-control" id="disabled_no" placeholder="ID บิล">
                                                    </div>
                                                    <div >
                                                        <p>วันที่สั่งซื้อ <input type="date" class="form-control" ></p>
                                                        <input type="time" class="form-control" >
                                                    </div>
<!--
                                                    <div>
                                                        <script>

                                                            var currentTime = new Date();
                                                            var hours = currentTime.getHours();
                                                            var minutes = currentTime.getMinutes();
                                                            if (minutes < 10) {
                                                                minutes = "0" + minutes;
                                                            }
                                                        </script>
                                                        <p>เวลาสั่งซื้อ <input type="text" id="time" >
                                                                <script>
                                                                    document.getElementById("time").value = hours + ":" + minutes + " ";
                                                                    if (hours > 11) {
                                                                        document.write("PM");
                                                                    }
                                                                    else
                                                                    {
                                                                        document.write("AM");
                                                                    }
                                                                </script></p>

                                                    </div>-->
                                                    <div>
                                                        <label for="disabled_shop">ชื่อร้านค้า</label>
                                                        <select class="form-control" id="shopName" name="shopName" required >
                                                            <option selected value="">Choose</option>
                                                            <?php
                                                            require_once '/function/func_addorder.php';
                                                            $getShop = getShop();
                                                            foreach ($getShop as $value) {
                                                                $val_idshop = $value['idshop'];
                                                                $val_name_shop = $value['name_shop'];
                                                                ?>
                                                                <option value="<?php echo $val_idshop; ?>"><?php echo $val_name_shop; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--End บิล -->

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <br>
                                <!-- ตารางสินค้าที่สั่งซื้อ -->
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        ตารางสินค้าที่สั่งซื้อ
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            
                                            <a href="popup_addproduct_order.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                                <span class="glyphicon glyphicon-plus"></span> เพิ่มสินค้า
                                            </a>
                                            <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><div align="center">รายการ</div></th>
                                                        <th><div align="center">ชื่อสินค้า</div></th>
                                                        <th><div align="center">ชื่อโรงงาน</div></th>
                                                        <th><div align="center">หน่วย</div></th>
                                                        <th><div align="center">จำนวน</div></th>
                                                        <th><div align="center">ราคาเปิด</div></th>
                                                        <th><div align="center">ต้นทุนลด%</div></th>
                                                        <th><div align="center">ขายลด%</div></th>
                                                        <th><div align="center">ขายเพิ่มสุทธิ</div></th>
                                                        <th><div align="center">ราคาขาย</div></th>
                                                        <th><div align="center">การกระทำ</div></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                            </table>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-4">
                                                <label for="disabled_no">ราคาขายรวมต่อบิล</label>
                                                <input type="text" class="form-control" id="disabled_no" placeholder=" " disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--End  ตารางสินค้าที่สั่งซื้อ --> 
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="form-group col-xs-8">
                                        <label for="exampleInputName2">รายละเอียดเพิ่มเติม</label>
                                        <textarea rows="4" cols="50" name="Other" form="usrform" class="form-control" placeholder="กรอกรายละเอียดเพิ่มเติม"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"></div>                              
                                    <a href="../interface_history_order/history_order.php" class="btn btn-warning btn-lg text-center">
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
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/js/custom.js"></script>


    </body>
</html>
<!-- Modalรายละเอียด -->
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