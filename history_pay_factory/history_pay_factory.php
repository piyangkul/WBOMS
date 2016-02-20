<?php
require_once 'function/func_history_pay_factory.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_pay_factory';
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
                            <h2> History Pay Factory </h2>   
                            <h5> ประวัติการจ่ายเงินโรงงาน </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="alert alert-danger" role="alert">1.กดที่ตัวเลขยอดเรียกเก็บและยอดสินค้าคืนรวมจะขึ้นข้อมูล </div>
                    <!-- ค้นหา -->
                    <div class="row">
                        <div class="col-md-3"></div>                        
                        <div class="col-md-6 "> 
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <div class="table-responsive">
                                        <div class="form-group">
                                            <label for="code_factory">ค้นหารหัสหรือชื่อโรงงาน</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                                                <input type="text" class="form-control" id="searchFactory" name="searchFactory" onkeyup="searchFactory()" placeholder="กรอกชื่อโรงงาน" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name_factory">โรงงาน</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                                                <select class="form-control" id="idFactory" name="idFactory" onchange="show_pay_factory_table()">
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
                    <br/>
                    <!-- ส่วนลดร้านค้า -->
                    <div class="row">
                        <div class="col-md-1"></div>                        
                        <div class="col-md-10 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>ข้อมูลการจ่ายเงินโรงงานรายเดือน-ปี</label>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_pay_factory_table">
                                         <!--show_pay_factory_table--> 
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
            show_pay_factory_table();
            function show_pay_factory_table() {
                var idfactory = $("#idFactory").val();
                $.get("action/action_pay_factory_show.php?idfactory=" + idfactory, function (data, status) {
                    $("#show_pay_factory_table").html(data);
                });
            }

            searchFactory();
            function searchFactory() {
                var searchFactory = $("#searchFactory").val();
                $.get("history_search_pay_factory.php?searchFactory=" + searchFactory, function (data, status) {
                    $("#idFactory").html(data);
                   show_pay_factory_table();
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