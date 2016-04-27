<?php
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_order';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
require_once 'function/func_addorder.php';
$val_idorder = $_GET['idorder']; //ส่งค่าpara
$getOrderEdit = getOrderEdit($val_idorder);
$getProductOrder = getProductOrder($val_idorder);
//echo "<pre>";
//print_r($getProductDetail);
//echo "</pre>";
$val_code_order_p = $getOrderEdit['code_order'];
$val_date_order_p = $getOrderEdit['date_order_p'];
$val_time_order_p = $getOrderEdit['time_order_p'];
$val_name_shop = $getOrderEdit['name_shop'] . " (" . $getOrderEdit['code_shop'] . ")";
$val_detail_order_p = $getOrderEdit['detail_order_p'];
$total_price_all = 0;
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

            /*  $(function () {
             var data = JSON.stringify(<?php //getShop2();                                                                      ?>);
             //var www = JSON.parse(data);
             //alert(www);
             alert(data);
             $("#code_order").autocomplete({
             source: data
             });
             });
             */
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
                                <h2> Detail Order </h2>   
                                <h5> รายละเอียดคำสั่งซื้อ </h5>
                            </div>
                        </div>
                        <!-- /. ROW  -->
                        <hr />
                        <a href="order.php" class="btn btn-danger btn-lg">
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
                                                    <span class="input-group-addon"><i class="fa fa-shopping-cart"  ></i></span>
                                                    <input type="text" class="form-control" id="name_order" name="name_shop" placeholder="ชื่อร้านค้า" value="<?= $val_name_shop ?>" disabled>
                                                </div>
                                                <div>
                                                    <label>No.บิล</label>
                                                    <input type="text" class="form-control" id="code_order" name="code_order" placeholder="ID บิล" value="<?= $val_code_order_p ?>" disabled/>                    
                                                </div>
                                                <label>วันที่สั่งซื้อ</label> 
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                    <input type="date" class="form-control" id ="date_order" name="date_order" value="<?= $val_date_order_p; ?>" disabled/>
                                                    <input type="time" class="form-control" id ="time_order" name="time_order" value="<?= $val_time_order_p ?>" disabled/>
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

                                                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                                    <thead>
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ชื่อโรงงาน</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคาต่อหน่วย</th>
                                                            <th>ต้นทุนลด%</th>
                                                            <th>ส่วนลด</th>
                                                            <th>ราคาขาย</th>
                                                            <th>การกระทำ</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($getProductOrder as $value) {
                                                            $i++;
                                                            $val_idproduct_order = $value['idproduct_order'];
                                                            $val_name_product = $value['name_product'];
                                                            $val_name_unit = $value['name_unit'];
                                                            $val_name_factory = $value['name_factory'];
                                                            $val_amount_product_order = $value['amount_product_order'];
                                                            $val_difference_product_order = $value['difference_product_order'];
                                                            $val_type_product_order = $value['type_product_order'];
                                                            $val_difference_amount_factory = $value['difference_amount_factory'];
                                                            $val_price_unit = $value['price_unit'];
                                                            $total_open = $val_price_unit * $val_amount_product_order;
                                                            $total_percent = $total_open - ($total_open * ($val_difference_product_order / 100));
                                                            $val_status_checktransport = $value['status_checktransport'];
                                                            $total_bath = $total_open + ($val_difference_product_order * $val_amount_product_order);
                                                            ?>
                                                            <tr>
                                                                <td><?= $i; ?></td>
                                                                <td><?= $val_name_product; ?></td>
                                                                <td><?= $val_name_factory; ?></td>
                                                                <td><?= $val_amount_product_order . " " . $val_name_unit; ?></td>
                                                                <td class ="text-right"><?= number_format($val_price_unit, 2); ?> </td>

                                                                <?php if ($val_type_product_order === 'PERCENT') { ?>
                                                                    <td><?= number_format($val_difference_amount_factory, 2)."%"; ?></td>
                                                                    <td><?= number_format($val_difference_product_order, 2) . "%"; ?></td>
                                                                    <td class ="text-right"><?= number_format($total_percent, 2); ?></td>
                                                                    <?php
                                                                    $total_price_all += $total_percent;
                                                                }
                                                                ?>
                                                                <?php if ($val_type_product_order === 'BATH') { ?>
                                                                    <td>-</td>
                                                                    <td><?= number_format($val_difference_product_order, 2) . " ฿"; ?></td>                                                                  
                                                                    <td class ="text-right"><?= number_format($total_bath, 2); ?></td> 
                                                                    <?php
                                                                    $total_price_all += $total_bath;
                                                                }


                                                                if ($val_status_checktransport === 'check') {
                                                                    ?> <td>
                                                                        <font color="green"><b>สินค้าถูกจัดส่งแล้ว</b></font>
                                                                    </td>
                                                                    <?php
                                                                } elseif ($val_status_checktransport === 'postpone') {
                                                                    ?> <td>
                                                                        <font color="blue"><b>สินค้าถูกเลื่อน</b></font>
                                                                    </td>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <td>
                                                                        <font color="red"><b>สินค้ายังไม่ถูกจัดส่ง</b></font>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                ?>    
                                                            </tr>
                                                        <?php } ?>

                                                </table>
                                            </div>
                                            <!--<label>สินค้าเพิ่มใหม่</label>
                                            <!--<div id="showUnit"></div>-->

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
                                            <textarea rows="4" cols="50" id = "detail_order" name ="detail_order" class="form-control" placeholder="กรอกรายละเอียดเพิ่มเติม" value="" disabled=""><?= $val_detail_order_p ?></textarea>
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
        <script src="../assets/js/custom.js"></script>

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
    showUnit();
    showUnitE();
    showUnitD();
    function delProduct(str) {
        var x;
        var idproduct_order = str;
        var idorder = <?= $val_idorder; ?>;
        if (confirm("คุณต้องการลบสินค้าตัวนี้ใช่ไหม") == true) {
            x = "You pressed OK!";
            var p = "&idproduct_order=" + idproduct_order;
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
            document.getElementById('editProduct' + idproduct_order).style.display = 'none';
            document.getElementById('deleteProduct' + idproduct_order).style.display = 'none';
            document.getElementById("del" + idproduct_order).innerHTML = 'สินค้าตัวนี้ถูกลบ';
            document.getElementById("del" + idproduct_order).style.color = "red";
            window.location.href = 'edit_order.php?idorder=' + idorder;

        }
    }
    $(document.body).on('hidden.bs.modal', function () {
        $('#myModal').removeData('bs.modal');
    });
    function showUnit() {
        $.get("action_editProduct.php?p=showUnit", function (data, status) {
            $("#showUnit").html(data);
        });
    }
    function showUnitE() {
        $.get("action_editProductE.php?p=showUnit", function (data, status) {
            $("#showUnitE").html(data);
        });
    }
    function showUnitD() {
        $.get("action_editProductD.php?p=showUnit", function (data, status) {
            $("#showUnitD").html(data);
        });
    }
    function updateTotalPer() {
        var x = document.getElementById("DifferencePer").value;
        var price = document.getElementById("total_price").value;
        var total = price - (price * (x / 100));
        document.getElementById("total").value = total;
        document.getElementById("DifferenceBath").disabled = true;
        document.getElementById("type").value = "PERCENT";
        if (x === "") {
            document.getElementById("DifferenceBath").disabled = false;
        }
    }
    function updateTotalBath() {
        var x = document.getElementById("DifferenceBath").value;
        var price = document.getElementById("total_price").value;
        var qwer = document.getElementById("idFactory2").value;
        var amount = document.getElementById("AmountProduct").value;
        var total = (qwer - x) * amount;
        document.getElementById("total").value = total;
        document.getElementById("type").value = "BATH";
        document.getElementById("DifferencePer").disabled = true;
        if (x === "") {
            document.getElementById("DifferencePer").disabled = false;
        }
    }
    function updateAmount() {
        var price = document.getElementById("idFactory2").value;
        var amount = document.getElementById("AmountProduct").value;
        var difference = document.getElementById("difference").value;
        var total = amount * price;
        var totals = total - (total * (difference / 100))
        document.getElementById("total_price").value = total;
        document.getElementById("cal_difference").value = totals;
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
                    $("#price").val(response);
                    $("#idFactory2").val(response);
                }
            });
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