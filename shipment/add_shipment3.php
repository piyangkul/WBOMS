<?php
require_once 'function/func_shipment.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'shipment';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//$name_factory = $_POST['factoryName'];
//$monthly = $_POST['monthly'];
?>
<?php
if (isset($_GET['idshipment_period'])and isset($_GET['idfactory'])) {
    $idshipment_period = $_GET['idshipment_period'];
    $getShipment_period = getShipment_periodByID($idshipment_period);
    $val_date_start = $getShipment_period['date_start'];
    $change_date_start = date("d-m-Y", strtotime($val_date_start));
    $val_date_end = $getShipment_period['date_end'];
    $change_date_end = date("d-m-Y", strtotime($val_date_end));

    $idfactory = $_GET['idfactory'];
    $getFactory = getFactoryByID($idfactory);
    $val_name_factory = $getFactory['name_factory'];

    $getCountshipment_perroid = getCountshipment_perroidByID($idfactory, $idshipment_period);
    $val_count_idorder_transport = $getCountshipment_perroid['count_idorder_transport'];

    $price = $_GET['price'];
    $status_shipment_factory = $_GET['status_shipment'];
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
                                <center><h4 class="text text-info"><b>โรงงาน</b> <?php echo $val_name_factory; ?></h4></center>
                                <center><h4 class="text text-info"><b>จำนวนใบขนส่ง</b> <?php echo $val_count_idorder_transport ?> <b>ใบ</b></h4></center>
                            </div>

                            <span>
                                <?php
                                if (isset($_GET['action'])) {
                                    if ($_GET['action'] == "addCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการเพิ่มสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถเพิ่มได้</h4></center>';
                                    } else if ($_GET['action'] == "editCompleted") {
                                        echo '<center><h4 class="text-success">คุณได้ทำการแก้ไขสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editError") {
                                        echo '<center><h4 class="text-danger">ผิดพลาด!! ไม่สามารถแก้ไขได้</h4></center>';
                                    } else if ($_GET['action'] == "delProduct_orderCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการลบรายการสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "delProduct_orderError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถลบรายการสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "addShipmentCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการเพิ่มข้อมูลการส่งสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addShipmentError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถเพิ่มข้อมูลการส่งสินค้ารายการสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "editProduct_orderCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการแก้ไขจำนวนสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editProduct_orderError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถแก้ไขจำนวนสินค้าได้</h4></center>';
                                    } else if ($_GET['action'] == "editStatus_check_priceCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการตรวจสอบยอดบิลแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "editStatus_check_priceError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถทำการตรวจสอบยอดบิลได้</h4></center>';
                                    } else if ($_GET['action'] == "addPayfactoryCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการเพิ่มการจ่ายเงินโรงงานสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "addPayfactoryError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถเพิ่มการจ่ายเงินโรงงานได้</h4></center>';
                                    } else if ($_GET['action'] == "delPayfactoryCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการลบการจ่ายเงินโรงงานสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "delPayfactoryError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถลบการจ่ายเงินโรงงานได้</h4></center>';
                                    } else if ($_GET['action'] == "EditShipmentCompleted") {
                                        echo '<center><h4 class="alert alert-success" role="alert">คุณได้ทำการแก้ไขข้อมูลการส่งสินค้าสำเร็จแล้ว</h4></center>';
                                    } else if ($_GET['action'] == "EditShipmentError") {
                                        echo '<center><h4 class="alert alert-danger" role="alert">ผิดพลาด!! ไม่สามารถทำการแก้ไขข้อมูลการส่งสินค้าได้</h4></center>';
                                    }
                                }
                                ?>
                            </span>
                            <?php
                            $price_pay_factory = getPrice_pay_factory($idshipment_period, $idfactory);
                            $val_status_shipment = $price_pay_factory['status_shipment'];
                            ?>
                            <div class="alert alert-success" role="alert"><b>คำชี้แจง</b> : ตรวจสอบรายการสินค้าที่สั่งซื้อและเพิ่มข้อมูลการส่งสินค้า
                                <br><b>หมายเหตุ</b> : เมื่อเพิ่มข้อมูลการส่งสินค้าแล้ว คุณจะไม่สามารถแก้ไขหรือลบจำนวนสินค้าได้ 
                                <br> เมื่อเพิ่มข้อมูลการจ่ายเงินโรงงานแล้ว คุณจะไม่สามารถแก้ไขข้อมูลการส่งสินค้าได้  
                            </div>
                            
                            <div class="alert alert-danger" role="alert">1.ติดแก้ไขหน่วยสินค้า </div>
                            <?php if($status_shipment_factory != 'pay') { ?>                           
                            <a href="popup_add_shipment3.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" type="submit" name="check_shipment" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"> 
                                <span class="fa fa-truck"></span> เพิ่มข้อมูลการส่งสินค้า
                            </a>
                            <?php } ?>
                            <?php // if ($val_status_shipment == 'check_price') { ?> <!--สถานะรอการจ่ายเงินโรงงาน และ ไม่มีข้อมูลการจ่ายเงิน ($val_idpay_factory == NULL) -->
<!--                                <a href="popup_add_payfactory.php?page=shipment3&idshipment_period=//<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal-lg">
                                    <span class="fa fa-building-o"></span> เพิ่มข้อมูลการจ่ายเงินโรงงาน
                                </a>-->
                            <?php // } ?>

                            <?php if ($val_status_shipment == 'check_price') { ?> <!--สถานะรอการจ่ายเงินโรงงาน และ ไม่มีข้อมูลการจ่ายเงิน&& $val_idpay_factory == NULL-->
                                <a href = "popup_add_payfactory.php?page=shipment3&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal-lg" data-toggle = "tooltip" title = "เพิ่มการจ่ายโรงงาน">
                                    <span class = "fa fa-building-o"></span> เพิ่มข้อมูลการจ่ายเงินโรงงาน
                                </a>
                            <?php } elseif ($val_status_shipment == 'pay') { ?> <!--สถานะรอการกดเสร็จสิ้น และ มีข้อมูลการจ่ายเงิน && $val_idpay_factory != NULL-->
                                <a href="action/action_delPayfactory.php?page=shipment3&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" onclick="if (!confirm('คุณต้องการลบหรือไม่')) {
                                                return false;
                                            }" class="btn btn-danger btn-lg" title="ลบการจ่ายเงินโรงงาน">
                                    <span class = "fa fa-building-o"></span> ลบข้อมูลการจ่ายเงินโรงงาน
                                </a>
                            <?php } ?>


                            <!--
                            <a href="popup_edit_payfactory.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#myModal">
                                <span class="fa fa-building-o"></span> แก้ไขข้อมูลการจ่ายเงินโรงงาน
                            </a>-->
                            <!--<div><br></div>-->

                            <!-- ตารางรายการสินค้า -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางรายการสินค้าที่สั่ง</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center " id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                                                    <th rowspan="2"><div align="center">วันที่สั่ง</div></th>
                                                    <th rowspan="2"><div align="center">ร้านค้า</div></th>
                                                    <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                                    <th rowspan="2"><div align="center">ราคาเปิดต่อหน่วย</div></th>
                                                    <th rowspan="2"><div align="center">จำนวน</div></th>
                                                    <th colspan="3"><div align="center">ข้อมูลการส่งสินค้า</div></th>
                                                    <th rowspan="2"><div align="center">การกระทำสินค้าที่สั่งซื้อ</div></th>
                                                </tr>
                                                <tr>
                                                    <th><div align="center">วันที่ส่ง</div></th>
                                                    <th><div align="center">ชื่อ/เล่มที่/เลขที่</div></th>
                                                    <th><div align="center">ค่าส่ง</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //มีเงื่อนไข การกำหนดช่วงเวลาที่สั่ง
                                                $getShipmentsByID = getShipmentByID($idfactory, $idshipment_period);
                                                $i = 0;
                                                foreach ($getShipmentsByID as $value) {
                                                    $i++;
                                                    $val_idorder_p = $value['idorder_p'];
                                                    $val_idproduct = $value['idproduct'];
                                                    $val_idproduct_order = $value['idproduct_order'];
                                                    $val_idorder_transport = $value['idorder_transport'];
                                                    $val_date_order_p = $value['date_order_p'];
                                                    $val_name_shop = $value['name_shop'];
                                                    $val_name_product = $value['name_product'];
                                                    $val_price_unit = $value['price_unit'];
                                                    $val_amount_product_order = $value['amount_product_order'];
                                                    $val_name_unit = $value['name_unit'];
                                                    $val_confirm_status_shipment = $value['status_shipment'];
                                                    $val_idtransport = $value['idtransport'];

                                                    $val_date_transport = $value['date_transport'];
                                                    if ($val_date_transport == NULL) {
                                                        $val_date_transport = "-";
                                                    }
                                                    $val_name_transport = $value['name_transport'];
                                                    if ($val_name_transport == NULL) {
                                                        $val_name_transport = "-";
                                                    }
                                                    $val_volume = $value['volume'];
                                                    if ($val_volume == NULL) {
                                                        $val_volume = "-";
                                                    }
                                                    $val_number = $value['number'];
                                                    if ($val_number == NULL) {
                                                        $val_number = "-";
                                                    }
                                                    $val_price_transport = $value['price_transport'];
                                                    if ($val_price_transport == NULL) {
                                                        $val_price_transport = "-";
                                                    }
                                                    ?>
                                                <?php 
                                                if($status_shipment_factory == "pay" || $status_shipment_factory == "finish"){ ?> <!-- สถานะโรงาน -->
                                                    <?php if($val_confirm_status_shipment == "pay" || $val_confirm_status_shipment == "finish"){ ?> <!-- สถานะรายการสินค้า -->
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_date_order_p; ?></td>
                                                        <td><?php echo $val_name_shop; ?></td>
                                                        <td><?php echo $val_name_product; ?></td>
                                                        <td><?php echo $val_price_unit; ?></td>
                                                        <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                                                        <td><?php echo $val_date_transport; ?></td>
                                                        <!--<td><?php //echo ($val_name_transport == "-" ? ($val_name_transport . "/" . $val_volume . "/" . $val_number) : ("<a href='popup_edit_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&idorder_transport=$val_idorder_transport&idtransport=$val_idtransport' data-toggle='modal' data-target='#myModal'>$val_name_transport/$val_volume/$val_number </a>")); ?></td>-->
                                                        <td><?php if($val_name_transport == "-"){
                                                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                                                        } elseif($val_status_shipment=="pay" || $val_confirm_status_shipment == "finish" ) {
                                                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                                                        }?> </td>
                                                        <td><?php echo $val_price_transport; ?></td>
                                                        <td>
                                                            <?php if ($val_date_transport != "-") { ?>
                                                                <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด">
                                                                    <span class="glyphicon glyphicon-list-alt"></span>
                                                                </a>
                                                            <?php } else { ?>
        <!--                                                                <a href="popup_detail_shipment.php?idorder_p=<?php echo $val_idorder_p; ?>&idproduct_order=<?php echo $val_idproduct_order; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="รายละเอียด">
                                                                    <span class="glyphicon glyphicon-list-alt"></span>
                                                                </a>-->
                                                                <a href="popup_edit_amount_product_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไขจำนวนสินค้า">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>                                                 
                                                                <a href="action/action_delProduct_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>" onclick="if (!confirm('คุณต้องการลบรายการสินค้าหรือไม่')) {
                                                                                    return false;
                                                                                }" class="btn btn-danger " title="ลบ">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }}  else { ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $val_date_order_p; ?></td>
                                                        <td><?php echo $val_name_shop; ?></td>
                                                        <td><?php echo $val_name_product; ?></td>
                                                        <td><?php echo $val_price_unit; ?></td>
                                                        <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                                                        <td><?php echo $val_date_transport; ?></td>
                                                        <!--<td><?php //echo ($val_name_transport == "-" ? ($val_name_transport . "/" . $val_volume . "/" . $val_number) : ("<a href='popup_edit_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&idorder_transport=$val_idorder_transport&idtransport=$val_idtransport' data-toggle='modal' data-target='#myModal'>$val_name_transport/$val_volume/$val_number </a>")); ?></td>-->
                                                        <td><?php if($val_name_transport == "-"){
                                                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                                                        } elseif($val_status_shipment == "check_price") {
                                                            echo "<a href='popup_edit_shipment3.php?idshipment_period=$idshipment_period&idfactory=$idfactory&idorder_transport=$val_idorder_transport&idtransport=$val_idtransport&status_shipment=$status_shipment_factory&price=$price' data-toggle='modal' data-target='#myModal'>$val_name_transport/$val_volume/$val_number </a>";
                                                        } else {
                                                            echo $val_name_transport . "/" . $val_volume . "/" . $val_number;
                                                        }?> </td>
                                                        <td><?php echo $val_price_transport; ?></td>
                                                        <td>
                                                            <?php if ($val_date_transport != "-") { ?>
                                                                <a href="popup_detail_shipment.php?idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&idorder_transport=<?php echo $val_idorder_transport; ?>&idtransport=<?php echo $val_idtransport; ?>&volume=<?php echo $val_volume; ?>&number=<?php echo $val_number; ?>&price_transport=<?php echo $val_price_transport; ?>&status_shipment=<?php echo $val_confirm_status_shipment; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal-lg" data-toggle="tooltip" title="รายละเอียด">
                                                                    <span class="glyphicon glyphicon-list-alt"></span>
                                                                </a>
                                                            <?php } else { ?>
        <!--                                                                <a href="popup_detail_shipment.php?idorder_p=<?php echo $val_idorder_p; ?>&idproduct_order=<?php echo $val_idproduct_order; ?>" class="btn btn-success " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="รายละเอียด">
                                                                    <span class="glyphicon glyphicon-list-alt"></span>
                                                                </a>-->
                                                                <a href="popup_edit_amount_product_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไขจำนวนสินค้า">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>                                                 
                                                                <a href="action/action_delProduct_order.php?idproduct_order=<?php echo $val_idproduct_order; ?>&idshipment_period=<?php echo $idshipment_period; ?>&idfactory=<?php echo $idfactory; ?>&price=<?php echo $price; ?>&status_shipment=<?php echo $status_shipment_factory; ?>" onclick="if (!confirm('คุณต้องการลบรายการสินค้าหรือไม่')) {
                                                                                    return false;
                                                                                }" class="btn btn-danger " title="ลบ">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php }?>
                                                
                                                    <?php }?> 
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <!--End ตารางรายการสินค้า -->

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