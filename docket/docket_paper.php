<?php
require_once 'function/func_docket.php';
require_once '../interface_shop/function/func_shop.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'docket';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
<?php
$idshipment_period = $_GET['idshipment_period'];
$idshop = $_GET['idshop'];
$getShop = getShopByID($idshop);
$val_name_shop = $getShop['name_shop'];
$val_name_region = $getShop['name_region'];
$val_name_province = $getShop['name_province'];
$val_tel_shop = $getShop['tel_shop'];
if ($val_tel_shop == NULL) {
    $val_tel_shop = "-";
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
                            <h2> Shop Bill </h2>   
                            <h5> การจัดการร้านค้า </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <a class="btn btn-danger btn-lg" onclick="Back()">
                        <span class="fa fa-arrow-circle-left"></span> Back
                    </a>
                    <div class="alert alert-danger" role="alert">1.ยังไม่ได้ทำC/N </div>
                    <div class="table-responsive">
                        <h3 class="text-center">ใบแจ้งหนี้ </h3>
                        <div id="table1">
                            <h4 class="text-center">ร้าน : <?php echo $val_name_shop; ?> &nbsp; &nbsp; &nbsp; ที่อยู่ : <?php echo $val_name_region; ?>  จ. <?php echo $val_name_province; ?> &nbsp; &nbsp; &nbsp; เบอร์โทรศัพท์ : <?php echo $val_tel_shop; ?></h4>

                            <table class="table table-striped table-bordered table-hover text-center " >

                                <thead>
                                    <tr>
                                        <th rowspan="2" valign="middle"><div align="center">ลำดับ</div></th>
                                        <th colspan="3"><div align="center">ข้อมูลการส่งสินค้า</div></th>
                                        <th rowspan="2"><div align="center">โรงงาน</div></th>
                                        <th rowspan="2"><div align="center">ชื่อสินค้า</div></th>
                                        <th rowspan="2"><div align="center">จำนวน</div></th> 
                                        <th rowspan="2"><div align="center">ราคาขาย/หน่วย</div></th>
                                        <th rowspan="2"><div align="center">ราคาขาย</div></th>
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
                                    $getProductDocketByID = getProductDocketByID($idshop, $idshipment_period);
                                    $i = 0;
                                    $n = 0;
                                    $sum_cost = 0;
                                    $sum_price_transport = 0;
                                    foreach ($getProductDocketByID as $value) {
                                        $i++;
                                        $val_idfactory = $value['idfactory'];
                                        $val_name_factory = $value['name_factory'];
                                        $val_name_product = $value['name_product'];
                                        $val_price_unit = $value['price_unit'];
                                        $val_amount_product_order = $value['amount_product_order'];
                                        $val_name_unit = $value['name_unit'];
                                        $val_date_transport = $value['date_transport'];
                                        $val_name_transport = $value['name_transport'];
                                        $val_volume = $value['volume'];
                                        if ($val_volume == NULL) {
                                            $val_volume = "-";
                                        }
                                        $val_number = $value['number'];
                                        if ($val_number == NULL) {
                                            $val_number = "-";
                                        }
                                        $val_price_transport = $value['price_transport'];
                                        $val_difference_product_order = $value['difference_product_order']; //ขายลด
                                        $val_type_product_order = $value['type_product_order'];
                                        if ($value['type_product_order'] == "PERCENT") {
                                            $cost = $val_price_unit - (($val_difference_product_order / 100.0) * $val_price_unit);
                                        } else {
                                            $cost = $val_price_unit - $val_difference_product_order;
                                        }
                                        $sale = $cost*$val_amount_product_order;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <?php
                                            $test = getProductDuplicateDocketByID($idshop, $idshipment_period, $val_name_transport, $val_number, $val_volume, $val_idfactory);
                                            if ($test > 1) {
                                                if ($n == 0) {
                                                    echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" >' . $val_date_transport . '</td>';
                                                    echo "<td style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" >' . $val_name_transport . "/" . $val_volume . "/" . $val_number . '</td>';
                                                    echo "<td class=\"text-right\" style=\"vertical-align:middle\" " . "rowspan=" . '"' . $test . '" valign="middle">' . number_format($val_price_transport, 2) . '</td>';
                                                    $sum_price_transport = $sum_price_transport + $val_price_transport;
                                                }
                                                $n++;
                                                if ($n == $test) {
                                                    $n = 0;
                                                }
                                            } else {
                                                ?>
                                                <td><?php echo $val_date_transport; ?></td>
                                                <td><?php echo $val_name_transport . "/" . $val_volume . "/" . $val_number; ?></td>
                                                <td class="text-right"><?php echo number_format($val_price_transport, 2); ?></td>
                                                <?php
                                                $sum_price_transport = $sum_price_transport + $val_price_transport;
                                            }
                                            ?>
                                            <td><?php echo $val_name_factory; ?></td>  
                                            <td><?php echo $val_name_product; ?></td>
                                            <td><?php echo $val_amount_product_order . " " . $val_name_unit; ?></td>
                                            <td class="text-right"><?php echo number_format($cost, 2); ?></td>
                                            <td class="text-right"><?php echo number_format($sale, 2); ?></td>
                                            <?php $sum_cost = $sum_cost + $sale; ?>
                                        </tr>
                                    <?php } ?>                                   
                                </tbody>
                            </table>
                            <div align="right">ราคาขายรวม &nbsp;&nbsp; <b><?php echo number_format($sum_cost, 2); ?></b> &nbsp;&nbsp; บาท </div>                                  
                            <div align="right">ค่าส่งรวม &nbsp;&nbsp; <b><?php echo number_format($sum_price_transport, 2); ?></b> &nbsp;&nbsp; บาท </div>
                            <div align="right">ยอดเงินเรียกเก็บสุทธิ &nbsp;&nbsp; <b><?php echo number_format($sum_cost + $sum_price_transport, 2); ?></b> &nbsp;&nbsp; บาท </div>
                        </div>
                        <p>
                            <button class="btn btn-info" id="btn1" type="submit">พิมพ์</button>
                        </p>
                    </div>
                    <!-- /. PAGE INNER  -->
                </div>
                <!-- /. PAGE WRAPPER  -->
            </div>
            <!-- /. WRAPPER  -->
            <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
            <!-- JQUERY SCRIPTS -->
            <!--<script src="../assets/js/jquery-1.10.2.js"></script>-->
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
                function Back() {
                    window.location.assign("docket.php");
                }
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });

                $(document.body).on('hidden.bs.modal', function () {
                    $('#myModal').removeData('bs.modal');
                });
            </script>
            <script src="../printMe/jquery-printme.js"></script>
            <script>
                $("#btn1").click(function () {
                    $("#table1").printMe({"path": "../printMe/libs/bootstrap.min.css", "title": "ใบแจ้งหนี้"});
                });
                $("#btn2").click(function () {
                    $("#table2").printMe({"path": "../printMe/libs/bootstrap.min.css", "title": "Bootstrap Table"});
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
<?php
//                                        $val_idorder_p = $value['idorder_p'];
//                                        $val_idproduct = $value['idproduct'];
//                                        $val_idproduct_order = $value['idproduct_order'];
//                                        $val_idorder_transport = $value['idorder_transport'];
//                                        $val_date_order_p = $value['date_order_p'];
                                        //$val_status_checktransport = $value['status_checktransport'];
                                        //$val_confirm_status_shipment = $value['status_shipment'];
                                        //$val_idtransport = $value['idtransport'];
                                        //$val_name_shop = $value['name_shop'];