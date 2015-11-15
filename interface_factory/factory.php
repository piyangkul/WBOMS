<?php
//require '../model/db_user.inc.php';
require_once 'function/func_factory.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'factory';
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

            <!--  CONNECT DATABASE  -->


            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2> Factory </h2>   
                            <h5> โรงงาน  </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <a href="popup_add_factory.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-plus"></span> เพิ่มโรงงาน
                            </a>
                            <br/>
                            <br/>
                            <span>
                                <?php
                                if (isset($_GET['action'])) {
                                    if ($_GET['action'] == "addCompleted") {
                                        echo "<center><h4>คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>";
                                    } else if ($_GET['action'] == "addError") {
                                        echo "<center><h4>ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>";
                                    } else if ($_GET['action'] == "editCompleted") {
                                        echo "<center><h4>คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>";
                                    } else if ($_GET['action'] == "editError") {
                                        echo "<center><h4>ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>";
                                    } else if ($_GET['action'] == "delCompleted") {
                                        echo "<center><h4>คุณได้ทำการลบสำเร็จแล้ว</h4></center>";
                                    } else if ($_GET['action'] == "delError") {
                                        echo "<center><h4>ผิดพลาด!! ไม่สามารถลบได้</h4></center>";
                                    }
                                }
                                ?>
                            </span>
                            <?php
//                            if (isset($_REQUEST['name_factory'])) {
//                                $getName = $_POST['name_factory'];
//                                $getTel = $_POST['tel_factory'];
//                                $getAddress = $_POST['address_factory'];
//                                $getContact = $_POST['contact_factory'];
//                                $getDiff = $_POST['difference_amount_factory'];
//                                $getDetail = $_POST['detail_factory'];
//                                $count = add_factory($getName, $getTel, $getAddress, $getContact, $getDiff, $getDetail);
//
//
//                                if ($count === false) {
//                                    die(print_r($con->errorInfo(), true));
//                                } else {
//                                    ?>

                                    <?php
//                                    echo "<center><h4>คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>";
//                                }
//                            }
//                            ?>
                            <!-- ตารางโรงงาน -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h5>ตารางโรงงาน</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">รหัสโรงงาน</div></th>
                                                    <th><div align="center">ชื่อโรงงาน</div></th>
                                                    <th><div align="center">เบอร์โทรศัพท์</div></th>
                                                    <th><div align="center">ผู้ติดต่อ</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //ดึงข้อมูลจากตาราง
                                                
                                                $getFactorys = getFactorys();
                                                foreach ($getFactorys as $value) {
                                                    $val_idfactory = $value['idfactory'];
                                                    $val_name_factory = $value['name_factory'];
                                                    $val_tel_factory = $value['tel_factory'];
                                                    $val_contact_factory = $value['contact_factory'];
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $val_idfactory; ?></td>
                                                        <td><?php echo $val_name_factory; ?></td>
                                                        <td><?php echo $val_tel_factory; ?></td>
                                                        <td><?php echo $val_contact_factory; ?></td>

                                                        <td>
                                                            <a href="popup_detail_factory.php" class="btn btn-success " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="รายละเอียด">
                                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                            </a>
                                                            <a href="popup_edit_factory.php?idfactory=<?php echo $val_idfactory; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                                                <span class="glyphicon glyphicon-edit"></span>
                                                            </a>
                                                            <a href="popup_delete_factory.php" class="btn btn-danger " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="ลบ">
                                                                <span class="glyphicon glyphicon-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                }
                                                ?>  
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--End ตารางโรงงาน -->
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