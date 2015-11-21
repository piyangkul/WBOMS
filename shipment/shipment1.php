<?php
require_once 'function/func_shipment.php';
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
                            <form class="form" action="shipment2.php" method="POST">
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <div class="table-responsive">
                                        <div class="form-group">
                                                <label for="factoryName"> ชื่อโรงงาน </label><label class="text-danger">*</label>
                                                <select class="form-control" id="factoryName" name="factoryName" >
                                                    <option selected>Choose</option>
                                                    <?php
                                                    require_once '../interface_factory/function/func_factory.php';
                                                    $getFactorys = getFactorys();
                                                    foreach ($getFactorys as $value) {
                                                        $val_idfactory = $value['idfactory'];
                                                        $val_name_factory = $value['name_factory'];
                                                        ?>
                                                        <option value="<?php echo $val_idfactory; ?>"><?php echo $val_name_factory; ?></option>
                                                    <?php } ?>
                                                </select>
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
                                                                <label>ตั้งแต่วันที่</label>
                                                                <input type="date" class="form-control" id="date_start" name="date_start" required onchange="getmonth();">
                                                            </div>

                                                            <div class="form-group col-xs-12">
                                                                <label>ถึงวันที่ </label>
                                                                <input type="date" class="form-control" id="date_end" name="date_end" required onchange="getmonth();">
                                                            </div>

                                                            <div class="form-group col-xs-12">
                                                                <label> ประจำเดือน </label>
                                                                <select class="form-control" id="monthly" name="monthly" >
                                                                    <option selected value="">Choose</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <center>
                                                <button type="submit" class="btn btn-info btn-lg">
                                                    <span class="glyphicon glyphicon-search"></span> เลือก
                                                </button>
                                                <a href="../interface_history_order/history_order.php" class="btn btn-danger btn-lg text-center">
                                                    <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                                                </a>
                                            </center>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </form>
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


            <script>
                function getmonth() {
                    var date_start = $("#date_start").val();
                    var datearr_start = date_start.split("-");
                    var date_end = $("#date_end").val();
                    var datearr_end = date_end.split("-");
//                    alert(datearr_start[1] + " " + datearr_end[1]);
                    var optionhtml = '<option selected value="">Choose</option><option value="'+datearr_start[1]+'">'+datearr_start[1]+'</option><option value="'+datearr_end[1]+'">'+datearr_end[1]+'</option>';
                    $("#monthly").html(optionhtml);
                }
            </script>
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
            <script>
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