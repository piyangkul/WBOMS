<?php
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'shipment';
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
                            <h2> Shipment </h2>   
                            <h5> การส่งสินค้า </h5>

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
                                        <div class="form-group">
                                            <label for="name_factory">โรงงาน</label>
                                            <input type="text" class="form-control" id="productCode" name="name_factory" placeholder="กรอกชื่อโรงงาน" required="">
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12 ">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <label>เลือกช่วงเวลาที่สั่งซื้อ</label>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <div class="form-group col-xs-12">
                                                                <label>ตั้งแต่วันที่ <input type="text" id="datepicker1"></label>
                                                            </div>
                                                            <div class ="form-group col-xs-12">
                                                                <script>
                                                                    var currentTime = new Date();
                                                                    var hours = currentTime.getHours();
                                                                    var minutes = currentTime.getMinutes();
                                                                    if (minutes < 10) {
                                                                        minutes = "0" + minutes;
                                                                    }
                                                                </script>
                                                            </div>
                                                            <div class="form-group col-xs-12">
                                                                <label>ถึงวันที่ <input type="text" id="datepicker2"></label>
                                                            </div>
                                                            <div class ="form-group col-xs-12">
                                                                <script>
                                                                    var currentTime = new Date();
                                                                    var hours = currentTime.getHours();
                                                                    var minutes = currentTime.getMinutes();
                                                                    if (minutes < 10) {
                                                                        minutes = "0" + minutes;
                                                                    }
                                                                </script>
                                                            </div>
                                                            <div class="form-group col-xs-12">
                                                                <label> ประจำเดือน .... </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <a href="#" class="btn btn-info btn-lg">
                                                    <span class="glyphicon glyphicon-search"></span> เลือก
                                                </a>
                                                <a href="../interface_history_order/history_order.php" class="btn btn-danger btn-lg text-center">
                                                    <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                                                </a>
                                            </center>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--End บิล -->
                        </div>
                    </div>
                    <!-- /. PAGE INNER  -->
                </div>
                <!-- /. PAGE WRAPPER  -->
            </div>
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
            <!-- Date Picker -->
            <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <link rel="stylesheet" href="/resources/demos/style.css"/>
            <script>
                                                                    $(function () {
                                                                        $("#datepicker1").datepicker();
                                                                        $("#datepicker2").datepicker();
                                                                    });
            </script>
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
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