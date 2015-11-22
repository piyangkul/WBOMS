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
                            <h2> History Order </h2>   
                            <h5> ประวัติคำสั่งซื้อ </h5>

                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <a href="../interface_add_order/add_order.php" class="btn btn-info btn-lg">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มคำสั่งซื้อ
                            </a>
                            <br/><br/>
                            <!-- ตารางประวัติคำสั่งซื้อ -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    ประวัติคำสั่งซื้อ
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <center>
                                                        <th><center>No.บิล</center></th>
                                                        <th>วันที่สั่งซื้อ</th>
                                                        <th>เวลาสั่งซื้อ</th>
                                                        <th>ชื่อร้านค้า</th>
                                                        <th><center>จำนวนรายการสินค้า</center></th>
                                                        <th>ราคารวมต่อบิล</th>
                                                        <th>สถานะบิล</th>
                                                        <th>การกระทำ</th>
                                                    </center>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Bill003</td>
                                                    <td>3/04/2015</td>
                                                    <td>9:00AM</td>
                                                    <td>AA</td>
                                                    <td>3</td>
                                                    <td>10000</td>
                                                    <td>ยังไม่เก็บเงิน</td>
                                                    <td> 

                                                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal1" data-toggle="tooltip" title="รายละเอียด">
                                                            <span class="glyphicon glyphicon-list-alt"></span>
                                                        </a>
                                                        <a href="popup_edit_order.php" class="btn btn-warning " data-toggle="modal" data-target="#myModal2" data-toggle="tooltip" title="แก้ไข">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </a>
                                                        <a href="popup_delete_history_order.php" class="btn btn-danger " data-toggle="modal" data-target="#myModal3" data-toggle="tooltip" title="ลบ">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bill002</td>
                                                    <td>3/04/2015</td>
                                                    <td>13:00PM</td>
                                                    <td>AA</td>
                                                    <td>2</td>
                                                    <td>5000</td>
                                                    <td>ยังไม่เก็บเงิน</td>
                                                    <td> 
                                                        <a href="#" class="btn btn-success" data-toggle="modal " data-target="#myModal">
                                                            <span class="glyphicon glyphicon-list-alt"></span>
                                                        </a>
                                                        <a href="#" class="btn btn-warning " data-toggle="modal " data-target="#myModal">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </a>
                                                        <a href="#" class="btn btn-danger " data-toggle="modal " data-target="#myModal">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bill001</td>
                                                    <td>2/04/2015</td>
                                                    <td>14:00PM</td>
                                                    <td>BB</td>
                                                    <td>4</td>
                                                    <td>12000</td>
                                                    <td>ยังไม่เก็บเงิน</td>
                                                    <td> 
                                                        <a href="#" class="btn btn-success" data-toggle="modal " data-target="#myModal">
                                                            <span class="glyphicon glyphicon-list-alt"></span>
                                                        </a>
                                                        <a href="#" class="btn btn-warning " data-toggle="modal " data-target="#myModal">
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                        </a>
                                                        <a href="#" class="btn btn-danger " data-toggle="modal " data-target="#myModal">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>
                                                    </td>
                                                </tr>
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
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/js/custom.js"></script>


    </body>
</html>
<!-- Modalรายละเอียด -->
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
<!-- Modalแก้ไข -->
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
<!-- Modalลบ -->
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