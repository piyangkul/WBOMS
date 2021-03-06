﻿<?php
session_start();
require_once 'function/func_addorder.php';
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'product_refunds';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
$date = date("Y-m-d");
$var = date('H:i');
$idshop = "";
$name_shop = "";
if (isset($_SESSION['idshopP'])) {
    $idshop = $_SESSION['idshopP'];
    $getShopAdd = getShopAdd($idshop);
    $name_shop = $getShopAdd['name_shop'] . " (" . $getShopAdd['code_shop'] . ")";
}

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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <script src="//code.jquery.com/jquery-1.10.2.js"></script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <script>
                var Shop = JSON.stringify(<?php echo getShop2(); ?>);
                var ShopP = JSON.parse(Shop);
                var shopName = new Array();
                var shopId = new Array();
                for (var i = 0; i < ShopP.length; i++) {
                    shopName.push(ShopP[i].name_shop + " (" + ShopP[i].code_shop + ")");
                    shopId["'" + ShopP[i].name_shop + " (" + ShopP[i].code_shop + ")" + "'"] = ShopP[i].idshop;
                }

                $(function () {
                    $("#name_shop").autocomplete({
                        source: shopName
                    });
                });
                function getShopId() {
                    var price = document.getElementById("name_shop").value;
                    document.getElementById("idshop").value = shopId["'" + price + "'"];
                    var oldname_shop = document.getElementById("oldnameshop").value;
                    var idshop = shopId["'" + price + "'"];
                    $.ajax({type: "GET",
                        url: "action/action_session.php",
                        async: false,
                        data: "idshop=" + idshop,
                        dataType: 'html',
                        success: function (www)
                        {
                            if (www === 'discon') {
                                alert('ร้านค้านี้ไม่เคยสั่งซื้อสินค้าเหล่านี้');
                                $("#name_shop").val(oldname_shop);
                                $("#oldnameshop").val(price);
                            }
                        }
                    });
                    if (document.getElementById("idshop").value > 0) {
                        document.getElementById('add_p').disabled = false;
                    } else {
                        document.getElementById('add_p').disabled = true;
                    }

                    showUnit();
                }
                function LoadShipment(str) {
                    //var idshipment = document.getElementById("idShipment").value;
                    //var amount = document.getElementById("AmountProduct").value;
                    alert(str);
                    if (str === "") {
                        //document.getElementById("factoryName").innerHTML = "";
                        return;
                    }
                    else {
                        $.ajax({type: "GET",
                            url: "action/action_ajaxDateShip.php",
                            async: false,
                            data: "q=chk&idshipment=" + str,
                            dataType: 'html',
                            success: function (response)
                            {
                                //alert(response)
                                if (response === '1') {
                                    //alert("สามารถเลือกได้");

                                }
                                else {
                                    alert("ไม่สามารถเลือกได้");
                                }

                            }
                        });

                        $.ajax({type: "GET",
                            url: "action/action_ajaxDateShip.php",
                            async: false,
                            data: "q=max&idshipment=" + str,
                            dataType: 'html',
                            success: function (response)
                            {

                                $("#maxDate").val(response);
                            }
                        });
                        $.ajax({type: "GET",
                            url: "action/action_ajaxDateShip.php",
                            async: false,
                            data: "q=min&idshipment=" + str,
                            dataType: 'html',
                            success: function (response)
                            {

                                $("#minDate").val(response);
                            }
                        });
                    }

                    var max = document.getElementById("maxDate").value;
                    var min = document.getElementById("minDate").value;

                    document.getElementById("date_order").max = max;
                    document.getElementById("date_order").min = min;
                }

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
                    <form action="action/action_addOrder.php" method="post"> 
                        <div class="row">
                            <div class="col-md-12">
                                <h2> Add product refunds</h2>   
                                <h5> เพิ่มสินค้าคืน </h5>
                            </div>
                        </div>
                        <!-- /. ROW  -->
                        <hr />

                        <a href="action/action_reset.php?cancel=cancel" class="btn btn-danger btn-lg">
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
                                                <label>ชื่อร้านค้า</label><font size="1" color ="red">*กรุณาเลือกร้านค้าก่อน</font>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                                                    <?php
                                                    if (isset($_SESSION['idshopP'])) {
                                                        if ($_SESSION['idshopP'] > 0) {
                                                            ?>
                                                            <input type="text" class="form-control" id="name_shop" name="name_shop" placeholder="กรุณาระบุชื่อร้านค้า" autocomplete= on onblur="getShopId()" value="<?= $name_shop; ?>"></input>
                                                            <input type = "hidden" id = "oldnameshop" name = "oldnameshop" value = "<?= $name_shop; ?>"></input>
                                                        <?php } else { ?>
                                                            <input type="text" class="form-control" id="name_shop" name="name_shop" placeholder="กรุณาระบุชื่อร้านค้า" autocomplete= on onblur="getShopId()" value=""></input>
                                                            <input type = "hidden" id = "oldnameshop" name = "oldnameshop" value = ""></input>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <input type="text" class="form-control" id="name_shop" name="name_shop" placeholder="กรุณาระบุชื่อร้านค้า" autocomplete= on onblur="getShopId()" value=""></input>
                                                        <input type = "hidden" id = "oldnameshop" name = "oldnameshop" value = ""></input>
                                                    <?php } ?>
<!--<input type="text" class="form-control" id="name_product" name="name_product" placeholder="กรุณาระบุชื่อสินค้า" autocomplete = "on" > -->
                                                    <input type = "hidden" id = "idshop" name = "idshop" value = "<?= $idshop; ?>"></input>

                                                </div>
                                                <label>รอบ</label><font size="1" color ="red"> กำหนดจากวันที่ใบสั่งซื้อล่าสุด</font>
                                                <div class = "input-group">
                                                    <span class = "input-group-addon"><i class = "fa fa-calendar-o" ></i></span>
                                                    <?php
                                                    $getShipment = getShipment();
                                                    $count = 1;
                                                    $date_end_f;
                                                    $date_start_f;
                                                    foreach ($getShipment as $value) {
                                                        $idshipment = $value['idshipment_period'];
                                                        $date_start = $value['date_start'];
                                                        $date_end = $value['date_end'];
                                                        $getCount = chkOrder($date_start, $date_end);
                                                        $countId = $getCount['countOrder'];
                                                        if ($countId > 0) {
                                                            if ($count == 1) {
                                                                $date_end_f = $date_end;
                                                                $date_start_f = $date_start;
                                                                ?>
                                                                <input type = "text" class = "form-control" id = "name_shipment" name = "name_shipment" value = "<?= $date_start . " ถึง " . $date_end; ?>" disabled/>
                                                                <input type = "hidden" class = "form-control" id = "idShipment" name = "idShipment" value = "<?= $idshipment; ?>"/>
                                                                <?php
                                                            }
                                                            $count++;
                                                            ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <input type = "hidden" class = "form-control" id = "maxDate" name = "maxDate"/>
                                                    <input type = "hidden" class = "form-control" id = "minDate" name = "minDate"/>
                                                </div>
                                                <label>วันที่สินค้าคืน</label>
                                                <div class = "input-group">
                                                    <span class = "input-group-addon"><i class = "fa fa-calendar-o" ></i></span>
                                                    <input type = "date" class = "form-control" id = "date_order" name = "date_order" value = "<?= $date_end_f; ?>" max = "<?= $date_end_f; ?>" min="<?= $date_start_f ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End บิล -->

                            </div>
                        </div>
                        <div align="right">
                            <button class="btn btn-danger btn-lg" type="button" onclick="if (confirm('คุณต้องการลบหน่วยสินค้าทั้งหมดหรือไม่')) {
                                        resetInfo();
                                    }">
                                <span class="glyphicon glyphicon-trash"></span> ลบข้อมูลทั้งหมด
                            </button>
                        </div>
                        <div class = "row">
                            <div class = "col-md-12">

                                <br>
                                    <!--ตารางสินค้าที่สั่งซื้ อ -->
                                    <div class = "panel panel-primary">
                                        <div class = "panel-heading">
                                            ตารางสินค้าคืน
                                        </div>
                                        <div class = "panel-body">
                                            <div class = "table-responsive">
                                                <?php if (isset($_SESSION['idshopP'])) { ?>
                                                    <button type = "button" href = "popup_addproduct_refunds.php" id = "add_p" name = "add_p" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal-lg">
                                                        <span class = "glyphicon glyphicon-plus"></span> เพิ่มสินค้า
                                                    </button>
                                                <?php } else { ?>
                                                    <button type = "button" href = "popup_addproduct_refunds.php" id = "add_p" name = "add_p" class = "btn btn-info btn-lg" data-toggle = "modal" data-target = "#myModal-lg" disabled>
                                                        <span class = "glyphicon glyphicon-plus"></span> เพิ่มสินค้า
                                                    </button>
                                                <?php } ?>
                                                <button class = "btn btn-danger btn-lg" type = "button" onclick = "if (confirm('คุณต้องการลบหน่วยสินค้าทั้งหมดหรือไม่')) {
                                                            resetUnit();
                                                        }">
                                                    <span class = "glyphicon glyphicon-trash"></span> ลบสินค้าทั้งหมด
                                                </button>
                                                <br/>
                                                <br/>

                                                <div id = "showUnit"></div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--End ตารางสินค้าที่สั่งซื้อ -->
                                    <div class = "row">
                                        <div class = "col-md-2"></div>
                                        <div class = "form-group col-xs-8">
                                            <label for = "exampleInputName2">รายละเอียดเพิ่มเติม</label>
                                            <textarea rows = "4" cols = "50" id = "detail_order" name = "detail_order" class = "form-control" placeholder = "กรอกรายละเอียดเพิ่มเติม" value = ""></textarea>
                                        </div>
                                    </div>
                                    <div class = "row">
                                        <div class = "col-md-4"></div>
                                       <button type='button' class="btn btn-danger btn-lg text-center" onclick="cancel_order()">
                                            <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                                        </button>
                                        <button type="submit" class="btn btn-info btn-lg text-center">
                                            <span class = "glyphicon glyphicon-floppy-save"></span> บันทึก
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!--/. PAGE INNER -->
            </div>
            <!--/. PAGE WRAPPER -->
        </div>
        <!--/. WRAPPER -->
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
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
                                                    $(document.body).on('hidden.bs.modal', function () {
                                                        $('#myModal').removeData('bs.modal');
                                                    });
                                                    $(document.body).on('hidden.bs.modal', function () {
                                                        $('#myModal-lg').removeData('bs.modal');
                                                    });
                                                    showUnit();
                                                    function showUnit() {
                                                        $.get("action_addProduct.php?p=showUnit", function (data, status) {
                                                            $("#showUnit").html(data);
                                                        });
                                                    }
                                                    function cancel_order() {
                                                        var confirms = confirm("คุณต้องการยกเลิกรายการสินค้าคืนนี้หรือไม่");
                                                        if (confirms === true) {
                                                            window.location.href = "action/action_reset.php?cancel=cancel";
                                                        }
                                                    }
                                                    function updateAmount() {
                                                        var price = document.getElementById("price_factory").value.replace(',', '');
                                                        var amount = document.getElementById("AmountProduct").value;
                                                        var diff = document.getElementById("diff").value;
                                                        var type_factory = document.getElementById("typefactory").value;
                                                        //var diff = document.getElementById("diff").value
                                                        if (type_factory === "PERCENT") {
                                                            var total = (price - ((price * diff)) / 100) * amount;
                                                            document.getElementById("price").value = (price - ((price * diff)) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                                            document.getElementById("total_price").value = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                                        } else {
                                                            var amount_all = document.getElementById("diffBath").value;
                                                            var total = ((price * 1) + (diff / amount_all)) * amount;
                                                            document.getElementById("price").value = ((price * 1) + (diff / amount_all)).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                                            document.getElementById("total_price").value = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                                        }
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
                                                                    $("#price_factory").val(response);
                                                                    $("#idFactory2").val(response);
                                                                }
                                                            });
                                                        }
                                                        var type = document.getElementById('typefactory').value;
                                                        var price = document.getElementById('price_factory').value;
                                                        var diff = document.getElementById('diff').value;
                                                        var amount = document.getElementById('AmountProduct').value;

                                                        var total_percent = price - ((price * diff) / 100)
                                                        if (type === 'PERCENT') {
                                                            document.getElementById('total_price').value = (total_percent * amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                                            document.getElementById('price').value = total_percent.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                                        }
                                                        else {
                                                            $.ajax({type: "GET",
                                                                url: "action/action_diffBath.php",
                                                                async: false,
                                                                data: "q=" + str,
                                                                dataType: 'html',
                                                                success: function (response)
                                                                {
                                                                    $("#diffBath").val(response);
                                                                }

                                                            });
                                                            var amount_all = document.getElementById('diffBath').value;
                                                            var total_bath = (price * 1) + (diff / amount_all);
                                                            document.getElementById('total_price').value = (total_bath * amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
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
                                                    function resetUnit() {
                                                        $.get("action_addProduct.php?p=resetUnit", function (data, status) {
                                                            if (data !== "-1") {
                                                                showUnit();
                                                                alert("ลบสินค้าคืนทั้งหมดแล้ว");
                                                            }
                                                            else {
                                                                alert("ไม่สามารถลบหน่วยได้");

                                                            }
                                                        });
                                                    }
                                                    function resetInfo() {
                                                        $.get("action_addProduct.php?p=resetInfo", function (data, status) {
                                                            if (data !== "-1") {
                                                                showUnit();
                                                                alert("ลบข้อมูลทั้งหมดแล้ว");
                                                            }
                                                            else {
                                                                alert("ลบข้อมูลทั้งหมดแล้ว");

                                                            }
                                                        });
                                                        document.getElementById('name_shop').value = "";
                                                        document.getElementById('add_p').disabled = true;
                                                        //document.getElementById('name_shop').disabled = false;
                                                    }
                                                    /*
                                                     function addProduct_Order() {
                                                     if (document.getElementById("name_shop").value.length > 0) {
                                                     
                                                     window.showModalDialog('',);
                                                     }
                                                     else {
                                                     alert("กรุณากรอกชื่อร้านค้า");
                                                     }
                                                     }
                                                     */

</script>