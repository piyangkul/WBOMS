<?php
require '../model/db_user.inc.php';
session_start();
if (!isset($_SESSION['username']))
    header('Location: ../index.php');

$p = 'shop';
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
                            <h2> Shop </h2>   
                            <h5> ร้านค้า </h5>

                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <a href="popup_add_shop.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มร้านค้า
                            </a>
                            <br/>
                            <br/>
                            <!-- ตารางร้านค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางร้านค้า</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">ชื่อร้านค้า</div></th>
                                                    <th><div align="center">เบอร์โทร</div></th>
                                                    <th><div align="center">ภาค</div></th>
                                                    <th><div align="center">จังหวัด</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //ดึงข้อมูลจากตาราง
                                                $i = 1;
                                                $result = get_shop();
                                                while ($shop = $result->fetch(PDO::FETCH_OBJ)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $shop->name_shop; ?></td>
                                                        <td><?php echo $shop->tel_shop; ?></td>                                                     
                                                        <td><?php echo $shop->name_region ?></td>
                                                        <td><?php echo $shop->name_province ?></td>
                                                        <td>
                                                            <!--
                                                            <a href="popup_detail_shop.php" class="btn btn-success " data-toggle="modal" data-target="#myModal2" data-toggle="tooltip" title="รายละเอียด">
                                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                            </a>
                                                            -->
                                                            <a href="popup_edit_shop.php?idshop_edit=<?php echo $shop->idshop; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </a>
                                                            <a href="shop_process.php?idshop=<?php echo $shop->idshop; ?>" onclick ="return confirm('คุณต้องการที่จะลบข้อมูลของ <?php echo $shop->name_shop; ?> หรือไม่?');" class="btn btn-danger"  data-toggle="tooltip" title="ลบ" >
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                    $i++;
                                                }
                                                ?>  
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--End ตารางร้านค้า -->

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
        <script>
            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal2').removeData('bs.modal')
            });
        </script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
        </script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/js/custom.js"></script>
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