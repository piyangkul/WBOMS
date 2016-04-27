<?php
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_order';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
require_once 'function/func_addorder.php';
$idproduct_order = $_GET['idproduct_order'];
$idunit = $_GET['idunit'];
$diffPer = $_GET['DifferencePer'];
$diffBath = $_GET['DifferenceBath'];
$type = $_GET['type'];
$getUnit = getUnit3($idunit);
$idshop;

$idProduct = $getUnit['idproduct'];
$code_product = $getUnit['code_product'];
$nameUnit = $getUnit['name_unit'];
$nameFactory = $getUnit['name_factory'];
$nameProduct = $getUnit['name_product'];
$amountProduct = $_GET['amount'];
$idFactory = $getUnit['idfactory'];
$diffFac = $getUnit['difference_amount_product'];
$price = $getUnit['price_unit'];
$totaldiff = ($price * $amountProduct) - ((($price * $amountProduct) * $diffFac) / 100);
$totaldiffPer = ($price * $amountProduct) - ((($price * $amountProduct) * $diffPer) / 100);
$totaldiffBath = ($price + $diffBath) * $amountProduct;
$nameP = "[" . $code_product . "]" . $nameProduct . " - " . $nameFactory;
if (isset($_SESSION['idshop'])) {
    $idshop = $_SESSION['idshop'];
}

//echo $_SESSION['detail'];
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
            //alert('<?//= getShop2(); ?>');
            var Shop = JSON.stringify(<?php echo getShop2(); ?>);

            //alert(Product);
            //alert(data);
            var ShopP = JSON.parse(Shop);

            //alert(ProductP);
            //data = JSON.parse(www+'');
            /*alert(data);*/
            //document.write(www[0].idshop+www[0].name_shop);
            var shopName = new Array();
            var shopId = new Array();
            // var idshop;


            for (var i = 0; i < ShopP.length; i++) {
                shopName.push(ShopP[i].name_shop);
                shopId["'" + ShopP[i].name_shop + "'"] = ShopP[i].idshop;
                //var obj = JSON.parse(item);
                //shopName[i++] = item["shop_name"];
                // shopId[i++] = item["idshop"];
                //alert(www[i].name_shop);
                //alert(item["shop_name"]);

            }

            //alert(data);
            $(function () {
                $("#name_shop").autocomplete({
                    source: shopName
                });
            });

            function getShopId() {
                //alert("Hello");
                var price = document.getElementById("name_shop").value;
                //alert(shopId["'" + price + "'"]);
                document.getElementById("idshop").value = shopId["'" + price + "'"];
                //idshop = shopId["'" + price + "'"];
                //alert(idshop);
            }
            //auto complete
            var Product = JSON.stringify(<?php echo getProduct4(); ?>);
            var ProductP = JSON.parse(Product);
            var productName = new Array();
            var productId = new Array();
            var factoryName = new Array;
            var factoryId = new Array;
            for (var i = 0; i < ProductP.length; i++) {
                productName.push(ProductP[i].name_product);
                productId["'" + ProductP[i].name_product + "'"] = ProductP[i].idproduct;
                factoryName["'" + ProductP[i].name_product + "'"] = ProductP[i].name_factory;
                factoryId["'" + ProductP[i].name_product + "'"] = ProductP[i].idfactory;
            }
            $(function () {
                $("#name_product").autocomplete({
                    source: productName
                });
            });
            function getProductID() {
                var name_shop = document.getElementById("name_product").value;
                document.getElementById("name_factory").value = factoryName["'" + name_shop + "'"];
                document.getElementById("idproduct").value = productId["'" + name_shop + "'"];
                document.getElementById("idfactory").value = factoryId["'" + name_shop + "'"];
                document.getElementById("type").value = factoryType["'" + name_shop + "'"];
                var id = productId["'" + name_shop + "'"];
                $.ajax({type: "GET",
                    url: "action/action_ajax_product.php",
                    async: false,
                    data: "q=" + id,
                    dataType: 'html',
                    success: function (response)
                    {
                        $("#idUnit").html(response);
                        //alert(response);
                    }
                });
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
                    <!-- <form action="action/action_addOrder.php" method="post"> -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">แก้ไขสินค้า</h4>
                    </div>
                    <br/>
                    <a href="add_order.php?idshop=<?= $idshop; ?>" class="btn btn-danger btn-lg">
                        <span class="fa fa-arrow-circle-left"></span> Back
                    </a>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="form-group col-xs-12">
                                <div class="form-group col-xs-12">
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="name_product">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" id="name_product" name="name_product" placeholder="กรุณาระบุชื่อสินค้า" value ="<?= $nameP ?>" disabled=""></input>
                                    <input type="hidden" id="idproduct" name="idproduct" value="<?= $idProduct ?>"></input>
                                    <input type="hidden" id="idshop" name="idshop" value="<?= $idshop; ?>"></input>
                                    <input type="hidden" class="form-control" id="name_factory" name="name_factory" placeholder="กรุณาระบุชื่อสินค้า" value ="<?= $nameFactory ?>" disabled></input>
                                    <input type="hidden" id="idfactory" name="idfactory" value ="<?= $idFactory ?>"></input>
                                    <h id="idFactory2"></h>
                                </div>
                                <div class="form-group col-xs-12" style="float:left;width:50%;">
                                    <label for="amount_product">จำนวน</label>
                                    <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" onkeyup="updateAmount()" value="<?= $amountProduct ?>">
                                </div>
                                <div class="form-group col-xs-12" style="float:left;width:50%;">
                                    <label for="name_product"> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>

                                    <select class="form-control" id="idUnit" name="idUnit" onchange="LoadData(this.value)" onkeyup="" required>
                                        <option selected value="<?= $idunit ?>"><?= $nameUnit ?></option>   
                                        <?php
                                        $getUnit = edit_unit($idProduct, $idunit);
                                        foreach ($getUnit as $value) {
                                            $val_idunit = $value['idunit'];
                                            $val_name_unit = $value['name_unit'];
                                            ?>
                                            <option value="<?= $val_idunit; ?>"><?= $val_name_unit; ?></option><?php
                                        }
                                        ?>     
                                    </select>                
                                    <div id="tee"></div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="disabled_price_unit">ราคาเปิดต่อหน่วย</label>
                                    <input type="text" class="form-control" id="price" readonly="true" onkeyup="cal_difference()" value="<?= number_format($price, 2); ?>">
                                </div>

                                <div class="form-group col-xs-12">
                                    <label for="disabled_price_unit">ราคาเปิดทั้งหมด</label>
                                    <input type="text" class="form-control" id="total_price" readonly="true" onkeyup="cal_difference()" value="<?= number_format($price * $amountProduct, 2); ?>">
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <label>ส่วนต่างราคาขาย</label>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive ">
                                                    <?php if ($type === "BATH") { ?>
                                                        <div class="panel-body">
                                                            <div class="table-responsive ">
                                                                <label for="name_product"> ขายเพิ่มสุทธิ </label>
                                                                <input type="text" class="form-control" placeholder="กรอกราคาขายเพิ่มสุทธิ" id="DifferenceBath" value="<?= number_format($diffBath, 2); ?>" onkeyup="updateAmount()"> </input>
                                                                <input type="hidden" id="type" name="type" value="<?= $type ?>">
                                                            </div>
                                                        </div>
                                                    <?php } elseif ($type === "PERCENT") { ?>
                                                        <div class="panel-body">
                                                            <div class="table-responsive">
                                                                <div class="form-group">
                                                                    <label for="disabled_cost_discounts_percent"> เปอร์เซ็นต์ส่วนลดราคาต้นทุน </label>
                                                                    <input type="text" class="form-control" id="difference" readonly="true" value ="<?= number_format($diffFac, 2); ?>" onkeyup="cal_difference()" >
                                                                </div>
                                                                <div class ="form-group">
                                                                    <label for="exampleInputName2"> ราคาต้นทุน</label>
                                                                    <input type="text" class="form-control" id="cal_difference" readonly="true" value = "<?= number_format($totaldiff, 2); ?>">
                                                                </div>
                                                                <label class="radio"> เปอร์เซ็นต์ส่วนลดราคาขายจริง </label>
                                                                <input type="text" class="form-control" placeholder="กรอก%ขายลด"  id="DifferencePer"  value="<?= $diffPer; ?>" onkeyup="updateAmount()"/></input>
                                                                <input type="hidden" id="type" name="type" value="<?= $type ?>">
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($type === "BATH") { ?>
                                    <div class="form-group col-xs-12">
                                        <label for="exampleInputName2"> ราคาขายจริง</label>
                                        <input  type="text" class="form-control" id="total" readonly="true" value="<?= number_format($totaldiffBath, 2) ?>"></input>
                                    </div>
                                <?php } ?>
                                <?php if ($type === "PERCENT") { ?>
                                    <div class="form-group col-xs-12">
                                        <label for="exampleInputName2"> ราคาขายจริง</label>
                                        <input  type="text" class="form-control" id="total" readonly="true" value="<?= number_format($totaldiffPer, 2) ?>"></input>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-xs-12">
                        <p id="alertPass"></p>

                        <a href="add_order.php?idshop=<?= $idshop; ?>" class="btn btn-danger btn-lg text-center">
                            <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                        </a>
                        <a type="button" class="btn btn-info btn-lg text-center" onclick="editProduct();" data-dismiss="modal">
                            <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                        </a>
                    </div>  
                    <!--</form>-->
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
<script>
                            showUnit();
                            function editProduct() {
                                var product_order = <?= $idproduct_order; ?>;
                                var idUnit = $("#idUnit").val();
                                var productName = $("#idproduct").val();
                                var factoryName = $("#idfactory").val();
                                var AmountProduct = $("#AmountProduct").val();
                                var difference = $("#difference").val();
                                var DifferencePer = $("#DifferencePer").val();
                                var DifferenceBath = $("#DifferenceBath").val();
                                var price = $("#price").val();
                                var total_price = $("#total_price").val().replace(",", "");
                                var total = $("#total").val().replace(",", "");
                                var type = $("#type").val();
                                if (AmountProduct.length > 0 && (DifferencePer > 0 || DifferenceBath > 0)) {
                                    if ($("#idshop").val().length > 0) {
                                        var idshop = $("#idshop").val();
                                        var p = "&idproduct_order=" + product_order + "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&difference=" + difference + "&AmountProduct=" + AmountProduct + "&DifferencePer=" + DifferencePer + "&DifferenceBath=" + DifferenceBath + "&price=" + price + "&total_price=" + total_price + "&total=" + total + "&type=" + type + "&idshop=" + idshop;
                                        // alert(p);
                                        $.get("action_addProduct.php?p=editProduct" + p, function (data, status) {
                                            //alert("Data: " + data + "\nStatus: " + status);
                                            if (data == "1") {
                                                $("#alert").html("บันทึกแล้ว")
                                                $("#idUnit").val("");
                                                $("#productName").val("");
                                                $("#factoryName").val("");
                                                $("#difference").val("");
                                                $("#AmountProduct").val("");
                                                $("#DifferencePer").val("");
                                                $("#DifferenceBath").val("");
                                                $("#price").val("");
                                                $("#total_price").val("");
                                                $("#total").val("");
                                                $("#type").val("");
                                                showUnit();
                                            }
                                            else {
                                                $("#idUnit").val("");
                                                $("#productName").val("");
                                                $("#factoryName").val("");
                                                $("#difference").val("");
                                                $("#AmountProduct").val("");
                                                $("#DifferencePer").val("");
                                                $("#DifferenceBath").val("");
                                                $("#price").val("");
                                                $("#total_price").val("");
                                                $("#total").val("");
                                                $("#type").val("");
                                                showUnit();

                                            }
                                        }
                                        );
                                        window.location.href = 'add_order.php?idshop=' + idshop;
                                    }
                                    else {
                                        var p = "&idproduct_order=" + product_order + "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&difference=" + difference + "&AmountProduct=" + AmountProduct + "&DifferencePer=" + DifferencePer + "&DifferenceBath=" + DifferenceBath + "&price=" + price + "&total_price=" + total_price + "&total=" + total + "&type=" + type;
                                        // alert(p);
                                        $.get("action_addProduct.php?p=editProduct" + p, function (data, status) {
                                            //alert("Data: " + data + "\nStatus: " + status);
                                            if (data == "1") {
                                                $("#alert").html("บันทึกแล้ว")
                                                $("#idUnit").val("");
                                                $("#productName").val("");
                                                $("#factoryName").val("");
                                                $("#difference").val("");
                                                $("#AmountProduct").val("");
                                                $("#DifferencePer").val("");
                                                $("#DifferenceBath").val("");
                                                $("#price").val("");
                                                $("#total_price").val("");
                                                $("#total").val("");
                                                $("#type").val("");
                                                showUnit();
                                            }
                                            else {
                                                $("#idUnit").val("");
                                                $("#productName").val("");
                                                $("#factoryName").val("");
                                                $("#difference").val("");
                                                $("#AmountProduct").val("");
                                                $("#DifferencePer").val("");
                                                $("#DifferenceBath").val("");
                                                $("#price").val("");
                                                $("#total_price").val("");
                                                $("#total").val("");
                                                $("#type").val("");
                                                showUnit();

                                            }
                                        }
                                        );
                                        window.location.href = 'add_order.php';
                                    }


                                }
                                else {
                                    alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                                }
                            }


                            function showUnit() {
                                $.get("action_addProduct.php?p=showUnit", function (data, status) {
                                    $("#showUnit").html(data);
                                });
                            }
                            function updateAmount() {
                                var price = document.getElementById("price").value.replace(",", "");
                                var amount = document.getElementById("AmountProduct").value;
                                var total = amount * price;
                                var total_all;
                                var type = document.getElementById("type").value;
                                if (type === "PERCENT") {
                                    var diffper = document.getElementById("DifferencePer").value;
                                    var difference = document.getElementById("difference").value;
                                    var totals = total - (total * (difference / 100));
                                    total_all = (total - (total * (diffper / 100)));
                                    document.getElementById("cal_difference").value = totals.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                }
                                else if (type === "BATH") {
                                    var diffbath = document.getElementById("DifferenceBath").value;
                                    total_all = total + (diffbath * amount);
                                }
                                document.getElementById("total_price").value = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                document.getElementById("total").value = total_all.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
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
                                var amount = document.getElementById("AmountProduct").value;
                                var type = document.getElementById("type").value;
                                //var price = 0;
                                if (str == "") {
                                    //document.getElementById("factoryName").innerHTML = "";
                                    return;
                                }
                                else if (str === "Choose") {
                                    document.getElementById("productName").disabled = false;
                                }
                                else {

                                    if (type === "PERCENT") {
                                        var diff = document.getElementById("DifferencePer").value;
                                        var diff_pro = document.getElementById('difference').value;
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
                                                //$("#total_price").val(response * amount);
                                                //$("#total").val((response * amount) - ((response * amount) * diff) / 100);
                                            }
                                        });
                                        var price = document.getElementById('price').value.replace(",", "");
                                        document.getElementById('total_price').value = (price * amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                        document.getElementById('total').value = ((price * amount) - ((price * amount) * diff) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                        document.getElementById('cal_difference').value = ((price * amount) - ((price * amount) * diff_pro) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                    }
                                    else {
                                        var diffB = document.getElementById("DifferenceBath").value;
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
                                                // $("#total_price").val(response * amount);
                                                //$("#total").val((response * amount) + (diffB * amount));
                                            }
                                        });
                                        var price = document.getElementById('price').value.replace(",", "");
                                        document.getElementById('total_price').value = (price * amount).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                        document.getElementById('total').value = ((price * amount) + (diffB * amount)).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                    }
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
                                document.getElementById("idproduct").value = str;
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