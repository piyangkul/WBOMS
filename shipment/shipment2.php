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
<?php
if (isset($_GET['idshipment_period'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $change_date_start = date("d-m-Y", strtotime($val_date_start));
    $val_date_end = $getShipment_period['date_end'];
    $change_date_end = date("d-m-Y", strtotime($val_date_end));
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
                    <a href="javascript: history.go(-1)" class="btn btn-danger btn-lg">
                        <span class="fa fa-arrow-circle-left"></span> Back
                    </a>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <center><h4 class="text text-info"><b>รอบการส่งที่</b> <?php echo $change_date_start; ?> ถึง <?php echo $change_date_end; ?></h4></center>
                            </div>
                            <br/>
                            <span>
                                <?php
//                                if (isset($_GET['action'])) {
//                                    if ($_GET['action'] == "addCompleted") {
//                                        echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>';
//                                    } else if ($_GET['action'] == "addError") {
//                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>';
//                                    } else if ($_GET['action'] == "editCompleted") {
//                                        echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>';
//                                    } else if ($_GET['action'] == "editError") {
//                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>';
//                                    } 
//                                }
                                ?>
                            </span>
                            <div class="alert alert-success" role="alert">
                                <b>หมายเหตุ</b> ถ้ามีการเพิ่มข้อมูลการจ่ายเงินโรงงานแล้ว จะเพิ่มรายการที่ส่งไม่ได้ --> ตัดบิลแล้วกลับมาส่งสินค้าเพิ่มไม่ได้
                                <br>เดิมที จำนวนคงค้างจะยังไม่มี(-) จะต้องมีการเพิ่มข้อมูลขนส่งไปก่อน1ครั้ง ถึงจะขึ้นจำนวนคงค้างหรือถ้าหมด จะแสดง0
                            </div>
                            <div class="alert alert-danger" role="alert">แก้ 1.มีเงื่อนไขการกดปุ่มการจ่ายเงินโรงงาน 2.รวมปุ่มเพิ่ม/แก้ไขการจ่ายเงินรง.เป็นปุ่มการจ่ายเงินรง. 5.กดปุ่มเสร็จสิ้น เมื่อทำโรงงานนั้นเสร็จแล้ว โดยมีเงื่อนไขต้องผ่าน2สถานะมาก่อน </div>
                            <!-- ตารางรายการสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางรายการสินค้า(แยกตามโรงงาน)</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center " id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th><div align="center">เสร็จสิ้น</div></th>
                                                    <th><div align="center">ลำดับ</div></th>
                                                    <th><div align="center">โรงงาน</div></th>
                                                    <th><div align="center">จำนวนรายการที่สั่งคงค้าง/ส่ง</div></th>
                                                    <th><div align="center">ยอดเงินรวมที่โรงงานเรียกเก็บ</div></th>
                                                    <th><div align="center">สถานะคำสั่งซื้อ</div></th>
                                                    <th><div align="center">การกระทำ</div></th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <?php
//                                                $getCountSumProduct_order = getCountSumProduct_order(); //(จากproduct_orderของทุกรง.ของทุกรอบการส่ง)
//                                                foreach ($getCountSumProduct_order as $value) {
//                                                    $val_CountSumProduct_order = $value['CountSumProduct_order'];
//                                                    $val_test1 = $value['name_factory'];
//                                                }
//
//                                                $getCountSendProduct_order = getCountSendProduct_order(); //(จากproduct_orderของทุกรง.ที่ถูกส่งแล้ว)
//                                                foreach ($getCountSendProduct_order as $value) {
//                                                    $val_CountSendProduct_order = $value['CountSendProduct_order'];
//                                                    $val_test2 = $value['name_factory'];
//                                                }
//                                                echo $val_test1;
//                                                echo $val_test2;
//                                                echo $val_CountSumProduct_order;
//                                                
                                                //$val_CountProduct_order = $val_CountSumProduct_order - $val_CountSendProduct_order;
//                                                    if ($val_CountProduct_order == 0) {
//                                                        $val_CountProduct_order = "-";
//                                                    } else {
//                                                        $val_CountProduct_order = $val_CountProduct_order;
//                                                    }
                                                ?>
                                                <?php
                                                //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
                                                $getFactoryByIDshipment_period = getFactoryByIDshipment_period2($idshipment_period);
                                                $leftArr = getCountLeftProduct_order(); //คงค้าง
                                                $i = 0;
//                                                echo '<pre>';
//                                                print_r($leftArr);
//                                                echo '</pre>';
                                                foreach ($getFactoryByIDshipment_period as $value) {
                                                    $i++;
                                                    $val_status_shipment = $value['status_shipment'];
                                                    $val_idshipment_period = $value['idshipment_period'];
                                                    $val_idfactory2 = $value['idfactory'];
                                                    $val_idfactory = searchArr($leftArr, 'idfactory', $value['idfactory']);
                                                    $val_name_factory = $value['name_factory'];
                                                    $val_CountCheck = $value['CountCheck'];
                                                    if ($val_CountCheck == NULL) {
                                                        $val_CountCheck = "-";
                                                    }
                                                    $val_price = $value['price'];
                                                    if ($val_price == NULL) {
                                                        $val_price = "-";
                                                    }

//                                                    echo '<pre>';
//                                                    print_r($value);
//                                                    echo '</pre>';
//
//                                                    echo '<pre>';
//                                                    print_r($leftArr["$val_idfactory"]);
//                                                    echo '</pre>';
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <a href="#" class="btn btn-info " data-toggle="tooltip" title="เปลี่ยนสถานะเป็นเสร็จสิ้น">
                                                                <span class="glyphicon glyphicon-ok"></span>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_name_factory; ?></td>
                                                        <td><?php echo ($leftArr["$val_idfactory"]['count_left'] == NULL ? '-' : $leftArr["$val_idfactory"]['count_left']) . "/" . $val_CountCheck; ?></td>
                                                        <!--<td><?php //echo implode($leftArr["$val_idfactory"],"/") ;                   ?></td>-->
                                                        <!--<td><?php //echo implode($leftArr["$val_idfactory"],"/", $val_CountCheck) ;                   ?></td>-->
                                                        <td><?php echo $val_price; ?></td>
                                                        <td>
                                                            <?php if ($val_status_shipment == NULL) { ?>
                                                                <img src = "../images/level0.png">
                                                                <?php } elseif ($val_status_shipment == 'add_shipment') { ?>
                                                                    <img src = "../images/level1.png">                                                            
                                                                    <?php } elseif ($val_status_shipment == 'check_price') { ?>
                                                                        <img src = "../images/level2.png">                                                            
                                                                        <?php } elseif ($val_status_shipment == 'pay') { ?>
                                                                            <img src = "../images/level3.png">   
                                                                            <?php } elseif ($val_status_shipment == 'finish') { ?>
                                                                                <img src = "../images/level4.png"> 
                                                                                <?php } ?>
                                                                                </td>
                                                                                <td>
                            <!--                                                            <a href="detail_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>" class="btn btn-success " data-toggle="tooltip" title="รายละเอียด">
                                                                                        <span class="glyphicon glyphicon-list-alt"></span>
                                                                                    </a>-->
                                                                                    <a href="add_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $val_price; ?>" class="btn btn-warning " data-toggle="tooltip" title="จัดการการส่งสินค้า">
                                                                                        <span class="glyphicon glyphicon-edit"></span>
                                                                                    </a>
                            <!--                                                            <a href="edit_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>" class="btn btn-warning " data-toggle="tooltip" title="แก้ไข">
                                                                                        <span class="glyphicon glyphicon-edit"></span>
                                                                                    </a>-->
                                                                                    <?php if ($val_status_shipment == 'check_price' && $val_idpay_factory == NULL) { ?> <!--สถานะรอการจ่ายเงินโรงงาน และ ไม่มีข้อมูลการจ่ายเงิน-->
                                                                                        <a href = "popup_add_payfactory.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $val_idfactory2; ?>&price=<?php echo $val_price; ?>" class = "btn btn-info " data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "การจ่ายโรงงาน">
                                                                                            <span class = "fa fa-plus "></span><span class = "fa fa-building-o"></span>
                                                                                        </a>
                                                                                    <?php } elseif($val_status_shipment == 'pay' && $val_idpay_factory != NULL) { ?> <!--สถานะรอการกดเสร็จสิ้น และ มีข้อมูลการจ่ายเงิน-->
                                                                                        <a href = "popup_edit_payfactory.php" class = "btn btn-info " data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "การจ่ายโรงงาน">
                                                                                            <span class = "glyphicon glyphicon-edit"></span><span class = "fa fa-building-o"></span>
                                                                                        </a>
                                                                                    <?php } ?>
                                                                                </td>
                                                                                </tr>

                                                                                <?php
                                                                            }
                                                                            ?> 
                                                                            </tbody>
                                                                            </table>

                                                                            </div>
                                                                            </div>
                                                                            </div>
                                                                            <!--End ตารางรายการสินค้า -->

                                                                            </div>
                                                                            </div>
                                                                            </div>
                                                                            <!--                <div class="alert alert-success" role="alert">
                                                                                                check vaild id shipment period
                                                                                            </div>-->
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
                                                                                    $('#myModal').removeData('bs.modal');
                                                                                });
                                                                            </script>
                                                                            <script>
                                                                                $(document.body).on('hidden.bs.modal', function () {
                                                                                    $('#myModal-lg').removeData('bs.modal');
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