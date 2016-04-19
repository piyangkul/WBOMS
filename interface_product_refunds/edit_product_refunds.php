﻿<?php
session_start();
require_once '/function/func_addorder.php';
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'product_refunds';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}

$val_idorder = $_GET['idorder']; //ส่งค่าpara
$getEditProductRefunds = getEditProductRefunds($val_idorder);
$getProductRefunds = getProductRefunds($val_idorder);
$total_price_all = 0;
$val_date_product_refunds = $getEditProductRefunds['date_product_refunds'];
$idshop = $getEditProductRefunds['idshop'];
$val_name_shop = $getEditProductRefunds['name_shop'];
$val_detail_order_p = $getEditProductRefunds['detail_product_refunds'];
$val_code_shop = $getEditProductRefunds['code_shop'];
$name_shop = $val_name_shop . " (" . $val_code_shop . ")";

$val_idshipment_period = $getEditProductRefunds['shipment_period_idshipment_period'];

$getDateShipment = getDateShipment();
$dateEnd = $getDateShipment['date_end'];
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
                    <form action="action/action_editOrder.php?idorder=<?php echo $val_idorder; ?>" method="post"> 
                        <div class="row">
                            <div class="col-md-12">
                                <h2> Edit Product Refunds </h2>   
                                <h5> แก้ไขสินค้าคืน </h5>

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
                                            <div class="form-group">   
                                                <label>ชื่อร้านค้า</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                                                    <input type="text" class="form-control" id="name_order" name="name_shop" placeholder="ชื่อร้านค้า" value="<?= $name_shop ?>" disabled>
                                                </div>
                                                <label>รอบ</label>
                                                <div class="input-group">
                                                    <span class = "input-group-addon"><i class = "fa fa-calendar-o" ></i></span>
                                                    <select class="form-control" id="idShipment" name="idShipment" onchange="LoadShipment(this.value)" disabled required>
                                                        <?php
                                                        $getShipment = getEditShipment($val_idshipment_period);
                                                        $idShipment = $getShipment['idshipment_period'];
                                                        $date_end = $getShipment['date_end'];
                                                        $date_start = $getShipment['date_start'];
                                                        ?>

                                                        <option value="<?= $idShipment ?>"><?= $date_start . " ถึง " . $date_end ?>    </option>>
                                                        <?php
                                                        /* foreach ($getShipment as $value) {
                                                          $idshipment = $value['idshipment_period'];
                                                          $date_start = $value['date_start'];

                                                          $date_end = $value['date_end'];
                                                          $getCount = chkOrder($date_start, $date_end);
                                                          $countId = $getCount['countOrder'];
                                                          if ($countId > 0) {
                                                          ?>
                                                          <option value="<?= $idshipment ?>"><?= $date_start . " ถึง " . $date_end ?>    </option>>
                                                          <?php
                                                          }
                                                          } */
                                                        ?>
                                                    </select>
                                                    <input type = "hidden" class = "form-control" id = "maxDate" name = "maxDate"/>
                                                    <input type = "hidden" class = "form-control" id = "minDate" name = "minDate"/>
                                                </div>
                                                <label>วันที่สั่งซื้อ</label> 
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                    <input type="date" class="form-control" id ="date_order" name="date_order" value="<?= $val_date_product_refunds; ?>" max="<?= $dateEnd; ?>" disabled>
                                                </div>
                                            </div>                                        

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
                                                <a href="popup_edit_addproduct_refunds.php?idorder=<?= $val_idorder; ?>&idshop=<?= $idshop; ?>" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                                    <span class="glyphicon glyphicon-plus"></span> เพิ่มสินค้า </a>
                                                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                                    <thead>
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ชื่อโรงงาน</th>
                                                            <th>หน่วย</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคาเปิดต่อสินค้า</th>
                                                            <th>ราคาเปิดทั้งหมด</th>
                                                            <th>การกระทำ</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;

                                                        foreach ($getProductRefunds as $value) {
                                                            $i++;
                                                            $val_idproduct_refunds = $value['idproduct_refunds'];
                                                            $val_name_product = $value['name_product'];
                                                            $val_name_unit = $value['name_unit'];
                                                            $val_name_factory = $value['name_factory'];
                                                            $val_amount_product_refunds = $value['amount_product_refunds'];
                                                            $val_status_product_refunds = $value['status_product_refund'];
                                                            $val_price_product_refunds = $value['price_product_refunds'];
                                                            $total = $val_price_product_refunds * $val_amount_product_refunds;
                                                            $total_price_all += $total;
                                                            $type_factory = $value['type_factory'];
                                                            ?>
                                                            <tr>
                                                                <td><?= $i; ?></td>
                                                                <td><?= $val_name_product; ?></td>
                                                                <td><?= $val_name_factory; ?></td>
                                                                <td><?= $val_name_unit; ?></td> 
                                                                <td id="amount<?= $val_idproduct_refunds; ?>"><?= $val_amount_product_refunds; ?></td>
                                                                <td id="price_table<?= $val_idproduct_refunds; ?>" class ="text-right"><?= number_format($val_price_product_refunds, 2); ?></td>
                                                                <td id="total_table<?= $val_idproduct_refunds; ?>" class ="text-right"><?= number_format($total, 2); ?></td>
                                                                <?php
                                                                if ($val_status_product_refunds === 'return') {
                                                                    ?> <td>
                                                                        <b>สินค้าถูกจัดส่งแล้ว</font></b>
                                                                    </td>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <td>
                                                                        <!--Button trigger modal -->

                                                                        <a href = "popup_edit_editproduct_refunds.php?idproduct_refunds=<?= $val_idproduct_refunds; ?>&idorder_product_refunds=<?= $val_idorder; ?>&idshop=<?= $idshop; ?>&type_factory=<?= $type_factory; ?>" id="editProduct<?= $val_idproduct_refunds; ?>" name="editProduct<?= $val_idproduct_refunds; ?>" class="btn btn-warning " data-toggle="modal" data-target="#myModal" data-toggle="tooltip" title="แก้ไข">
                                                                            <span class = "glyphicon glyphicon-edit"></span>
                                                                        </a>
                                                                        <a class = "btn btn-danger" data-toggle = "modal" data-target = "#myModal3" data-toggle = "tooltip" title = "ลบ" id="deleteProduct<?= $val_idproduct_refunds; ?>" name="deleteProduct<?= $val_idproduct_refunds; ?>" onclick="delProduct(<?= $val_idproduct_refunds; ?>,<?= $val_price_product_refunds * $val_amount_product_refunds; ?>);">
                                                                            <span class = "glyphicon glyphicon-trash"></span>
                                                                        </a>           
                                                                        <center><b id ="del<?php echo $val_idproduct_refunds; ?>"><font color="red"></font></b></center>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                ?>    
                                                            </tr>

                                                            <?php
                                                        }
                                                        ?>
                                                        <tr id="showUnit">
                                                        </tr>
                                                </table>
                                            </div>
                                            <div id="showUnit"></div>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-4">
                                                <label for="disabled_no">ราคาขายรวมต่อบิล</label>
                                                <input type="text" class="form-control" id="total_price_all" name="total_price_all" value="<?= number_format($total_price_all, 2); ?>"  readonly>
                                            </div>   
                                        </div>
                                    </div>
                                    <!--End  ตารางสินค้าที่สั่งซื้อ --> 
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="form-group col-xs-8">
                                            <label for="exampleInputName2">รายละเอียดเพิ่มเติม</label>
                                            <textarea rows="4" cols="50" id = "detail_order" name ="detail_order" class="form-control" placeholder="กรอกรายละเอียดเพิ่มเติม" value=""><?= $val_detail_order_p ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>                              
                                        <button type="submit" class="btn btn-info btn-lg text-center">
                                            <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                                        </button>
                                        <a href="product_refunds.php" class="btn btn-danger btn-lg text-center">
                                            <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </form>
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
<script>
</script>
<script>
    $(document.body).on('hidden.bs.modal', function () {
        $('#myModal').removeData('bs.modal');
    });
    showUnit();
    function delProduct(str, price) {
        var x;
        var idproduct_refunds = str;
        var price_p = price;
        var idorder = <?= $val_idorder; ?>;

        if (confirm("คุณต้องการลบสินค้าตัวนี้ใช่ไหม" + price_p + idorder) == true) {
            x = "You pressed OK!";
            var p = "&idproduct_refunds=" + idproduct_refunds + "&price_product_refunds=" + price_p + "&idorder=" + idorder;
            //alert(p);
            $.get("action_editProductD.php?p=addProduct" + p, function (data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                if (data == "1") {
                    $("#alert").html("บันทึกแล้ว")
                    showUnitD();
                }
                else {
                    showUnitD();

                }
            });

            document.getElementById('editProduct' + idproduct_refunds).style.display = 'none';
            document.getElementById('deleteProduct' + idproduct_refunds).style.display = 'none';
            document.getElementById('del' + idproduct_refunds).innerHTML = 'สินค้าตัวนี้ถูกลบ';
            document.getElementById('del' + idproduct_refunds).style.color = "red";
            var x = document.getElementById('total_price_all').value;
            var total_price_all = x - price;
            document.getElementById('total_price_all').value = total_price_all;
            window.location.href = 'edit_product_refunds.php?idorder=' + idorder;
        }

    }
    function showUnit() {
        $.get("action_editProduct.php?p=showUnit", function (data, status) {
            $("#showUnit").html(data);
        });
    }

    function updateAmount() {
        var price = document.getElementById("price").value;
        var amount = document.getElementById("AmountProduct").value;
        var x = price.replace(",", "");
        var total = amount * x;
        document.getElementById("total_price").value = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    }

    function ChangeProduct() {
        var x = document.getElementById("factoryName").value;
        document.getElementById("idFactory2").innerHTML = "You selected: " + x;
        if (x === "Choose") {
            document.getElementById("productName").disabled = true;
        }
        else {
            document.getElementById("productName").disabled = false;
        }
    }
    function LoadData(str) {
        document.getElementById("idUnit").value = str;
        //var amount = document.getElementById("AmountProduct").value;

        if (str == "") {
            //document.getElementById("factoryName").innerHTML = "";
            return;
        }
        else if (str === "Choose") {
            document.getElementById("productName").disabled = false;
        }
        else {
            $.ajax({type: "GET",
                url: "action/action_ajax.php",
                async: false,
                data: "q=" + str,
                dataType: 'html',
                success: function (response)
                {
                    $("#total_price").val(response);
                    $("#price_factory").val(response);
                    $("#idFactory2").val(response);
                }
            });
        }
        var type = document.getElementById('typefactory').value;
        var price = document.getElementById('price_factory').value;
        var diff = document.getElementById('diff').value;
        var total_bath = (price * 1) + (diff * 1);
        var total_percent = price - ((price * diff) / 100)
        if (type === 'PERCENT') {
            document.getElementById('price').value = total_percent.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }
        else {
            document.getElementById('price').value = total_bath.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }
    }
    function LoadFactory(str) {
        document.getElementById("factoryName").value = str;
        if (str == "") {
            //document.getElementById("factoryName").innerHTML = "";
            return;
        }
        else {
            $.ajax({type: "GET",
                url: "action/action_ajax_difference.php",
                async: false,
                data: "q=" + str,
                dataType: 'html',
                success: function (wer)
                {
                    $("#difference").val(wer);
                    //alert(wer);
                }
            });
            $.ajax({type: "GET",
                url: "action/action_ajax_factory.php",
                async: false,
                data: "q=" + str,
                dataType: 'html',
                success: function (response)
                {
                    $("#productName").html(response);
                    //alert(response);
                }
            });
        }
    }

    function LoadProduct(str) {
        document.getElementById("productName").value = str;
        if (str == "") {
            //document.getElementById("factoryName").innerHTML = "";
            return;
        }

        else {
            $.ajax({type: "GET",
                url: "action/action_ajax_product.php",
                async: false,
                data: "q=" + str,
                dataType: 'html',
                success: function (response)
                {
                    $("#idUnit").html(response);
                    //alert(response);
                }
            });
        }

    }
</script>