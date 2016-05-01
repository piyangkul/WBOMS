<?php
session_start();
require_once 'function/func_addorder.php';
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
                                <h2> Detail Product Refunds </h2>   
                                <h5> รายละเอียดสินค้าคืน </h5>

                            </div>
                        </div>
                        <!-- /. ROW  -->
                        <hr />
                        <a href="product_refunds.php?cancel=cancel" class="btn btn-danger btn-lg">
                            <span class="fa fa-arrow-circle-left"></span> Back
                        </a>
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
                                                <label>วันที่สินค้าคืน</label> 
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
                                            ตารางสินค้าคืน
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">ลำดับ</th>
                                                            <th class="text-center">ชื่อสินค้า</th>
                                                            <th class="text-center">ชื่อโรงงาน</th>
                                                            <th class="text-center">จำนวน</th>
                                                            <th class="text-center">ราคาเปิดต่อหน่วย</th>
                                                            <th class="text-center">ส่วนลด</th>
                                                            <th class="text-center">ราคาคืนต่อหน่วย</th>
                                                            <th class="text-center">ราคาคืนทั้งหมด</th>
                                                            <th class="text-center">การกระทำ</th> 
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
                                                            $val_idunit = $value['idunit'];
                                                            $val_idproduct = $value['idproduct'];
                                                            $total = $val_price_product_refunds * $val_amount_product_refunds;
                                                            $total_price_all += $total;
                                                            $type_factory = $value['type_product_refunds'];
                                                            $difference_product_refunds = $value['difference_product_refunds'];

                                                            $amount_plus = 1;
                                                            $getDiff = getDiffBathaction($val_idproduct, $val_idunit);
                                                            foreach ($getDiff as $value) {
                                                                $val_amount_unit = $value['amount_unit'];
                                                                $val_price = $value['price_unit'];
                                                                $amount_plus = $val_amount_unit * $amount_plus;
                                                            }
                                                            ?>
                                                            <tr>
                                                                <tr>
                                                                    <td><?= $i; ?></td>
                                                                    <td><?= $val_name_product; ?></td>
                                                                    <td><?= $val_name_factory; ?></td>

                                                                    <td id="amount<?= $val_idproduct_refunds; ?>"><?= $val_amount_product_refunds . " " . $val_name_unit; ?></td>
                                                                    <?php if ($type_factory === "PERCENT") { ?>
                                                                        <td id="price<?= $val_idproduct_refunds; ?>"><?= number_format(($val_price_product_refunds * 100) / (100 - $difference_product_refunds), 2); ?></td>
                                                                    <?php } else { ?>
                                                                        <td id="price<?= $val_idproduct_refunds; ?>"><?= number_format(($val_price_product_refunds * 1) - ($difference_product_refunds / $amount_plus), 2); ?></td>
                                                                    <?php } ?>
                                                                    <?php if ($type_factory === "PERCENT") { ?>
                                                                        <td id="diff<?= $val_idproduct_refunds; ?>"><?= number_format($difference_product_refunds, 2) . "%"; ?></td>
                                                                    <?php } else { ?>
                                                                        <td id="diff<?= $val_idproduct_refunds; ?>"><?= number_format($difference_product_refunds / $amount_plus, 2) . " ฿"; ?></td>
                                                                    <?php } ?>
                                                                    <td id="price_table<?= $val_idproduct_refunds; ?>" class ="text-right"><?= number_format($val_price_product_refunds, 2); ?></td>
                                                                    <td id="total_table<?= $val_idproduct_refunds; ?>" class ="text-right"><?= number_format($total, 2); ?></td>
                                                                    <?php
                                                                    if ($val_status_product_refunds === 'returned') {
                                                                        ?> <td>
                                                                            <font color="green"><b>สินค้าถูกคืนโรงงานแล้ว</b></font>
                                                                        </td>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td>
                                                                            <font color="red"><b>สินค้ายังไม่คืนโรงงาน</b></font>
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
                                                                    <textarea rows="4" cols="50" id = "detail_order" name ="detail_order" class="form-control" placeholder="กรอกรายละเอียดเพิ่มเติม" value="" disabled><?= $val_detail_order_p ?></textarea>
                                                                </div>
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