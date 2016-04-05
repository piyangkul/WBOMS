<?php
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_order';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
require_once '/function/func_addorder.php';
$idorder = $_GET['idorder'];
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
            var factoryName = new Array();
            var factoryId = new Array();
            var factoryDiff = new Array();
            var factoryType = new Array();
            for (var i = 0; i < ProductP.length; i++) {
                productName.push(ProductP[i].name_product);
                productId["'" + ProductP[i].name_product + "'"] = ProductP[i].idproduct;
                factoryName["'" + ProductP[i].name_product + "'"] = ProductP[i].name_factory;
                factoryId["'" + ProductP[i].name_product + "'"] = ProductP[i].idfactory;
                factoryDiff["'" + ProductP[i].name_product + "'"] = ProductP[i].difference_amount_factory;
                factoryType["'" + ProductP[i].name_product + "'"] = ProductP[i].type_factory;
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
                document.getElementById("difference").value = factoryDiff["'" + name_shop + "'"];
                document.getElementById("typefactory").value = factoryType["'" + name_shop + "'"];
                if (document.getElementById("typefactory").value == "PERCENT") {
                    document.getElementById("PERCENT").style.display = "inline";
                    document.getElementById("BATH").style.display = "none";
                }
                if (document.getElementById("typefactory").value == "BATH") {
                    document.getElementById("BATH").style.display = "inline";
                    document.getElementById("PERCENT").style.display = "none";


                }
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
                        <h4 class="modal-title" id="myModalLabel">เพิ่มสินค้า</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="form-group col-xs-12">
                                <div class="form-group col-xs-12">
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="name_product">ชื่อสินค้า</label>
                                    <input type="text" class="form-control" id="name_product" name="name_product" placeholder="กรุณาระบุชื่อสินค้า" onblur="getProductID()" autocomplete= "on" ></input>
                                    <input type="hidden" id="idproduct" name="idproduct"></input>
                                    <input type="hidden" class="form-control" id="typefactory" name="typefactory"></input>
                                    <h id="idFactory2"></h>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="name_factory">ชื่อโรงงาน</label> <font size="1" color ="red">*กรุณาเลือกสินค้า</font>
                                    <input type="text" class="form-control" id="name_factory" name="name_factory" placeholder="กรุณาระบุชื่อสินค้า" disabled></input>
                                    <input type="hidden" id="idfactory" name="idfactory"></input>
                                </div>
                                <div class="form-group col-xs-12" style="float:left;width:50%;">
                                    <label> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>
                                    <select class="form-control" id="idUnit" name="idUnit" onchange="LoadData(this.value)" required>
                                        <option>กรุณาเลือกหน่วยขาย</option>
                                    </select>
                                    <div id="tee"></div>
                                </div>
                                <div class="form-group col-xs-12" style="float:left;width:50%;">
                                    <label for="amount_product">จำนวน</label>
                                    <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" onkeyup="updateAmount()"></input>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="disabled_price_unit">ราคาเปิดต่อหน่วย //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                                    <input type="text" class="form-control" id="price" readonly="true" onkeyup="cal_difference()"></input>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="disabled_price_unit">ราคาเปิดทั้งหมด //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                                    <input type="text" class="form-control" id="total_price" readonly="true" onkeyup="cal_difference()"></input>
                                </div>
                                <div class="form-group col-xs-12 diff" id="PERCENT">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <label>ส่วนต่างราคาขาย//ระบบจะดึงส่วนต่างราคาขายที่ให้แต่ละร้านค้า(สินค้าเชื่อมร้านค้า) </label>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <div class="form-group">
                                                        <label for="disabled_cost_discounts_percent" id="name_difference"> ต้นทุนลดเป็น% (%ที่โรงงานลดให้เรา) </label>
                                                        <input type="text" class="form-control" id="difference" readonly="true" onkeyup="cal_difference()"></input>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputName2"> ดังนั้นราคาต้นทุน //ระบบคิดอัตโนมัติตามหน่วยที่เลือก</label>
                                                        <input type="text" class="form-control" id="cal_difference" readonly="true" ></input>
                                                    </div>
                                                    <label class="radio"> ขายลดเปอร์เซ็นต์//8% = 44.8 </label>
                                                    <input type="text" class="form-control" placeholder="กรอก%ขายลด"  id="DifferencePer" value="" onkeyup="updateTotalPer()"/></input>

                                                    <h id="type"></h>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 diff" id="BATH">
                                    <div class="col-md-12 col-sm-12 ">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <label>ส่วนต่างราคาขาย//ระบบจะดึงส่วนต่างราคาขายที่ให้แต่ละร้านค้า(สินค้าเชื่อมร้านค้า) </label>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive ">
                                                    <label for="name_product"> ขายเพิ่มสุทธิ </label>
                                                    <input type="text" class="form-control" placeholder="กรอกราคาขายเพิ่มสุทธิ" id="DifferenceBath" value="" onkeyup="updateTotalBath()"> </input>
                                                    <h id="type"></h>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="exampleInputName2"> ดังนั้นราคาขาย//ระบบคำนวนอัตโนมัติ(ราคาเปิด-ส่วนต่างราคาขาย=560-44.8) </label>
                                    <input  type="text" class="form-control" id="total" readonly="true" value=""></input>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-xs-12">
                        <p id="alertPass"></p>
                        <a href="edit_order.php?idorder=<?= $idorder ?>" type="button" class="btn btn-info btn-lg text-center" onclick="addProduct();" data-dismiss="modal">
                            <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                        </a>
                        <a href="edit_order.php?idorder=<?= $idorder ?>" class="btn btn-danger btn-lg text-center">
                            <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
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
                            $(document.body).on('hidden.bs.modal', function () {
                                $('#myModal').removeData('bs.modal');
                            });
                            showUnit();
                            function showUnit() {
                                $.get("action_addProduct.php?p=showUnit", function (data, status) {
                                    $("#showUnit").html(data);
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
                                var total = (qwer * amount) + (x * amount);
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

                            function addProduct() {
                                var idorder = <?= $idorder; ?>;
                                var idUnit = $("#idUnit").val();
                                var productName = $("#idproduct").val();
                                var factoryName = $("#idfactory").val();
                                var AmountProduct = $("#AmountProduct").val();
                                var difference = $("#difference").val();
                                var DifferencePer = $("#DifferencePer").val();
                                var DifferenceBath = $("#DifferenceBath").val();
                                var price = $("#price").val();
                                var total_price = $("#total_price").val();
                                var total = $("#total").val();
                                var type = $("#type").val();
                                //alert(idUnit);
                                //alert(AmountProduct);
                                //alert(DifferencePer);
                                //alert(DifferenceBath);
                                var p = "&idorder=" + idorder + "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&difference=" + difference + "&AmountProduct=" + AmountProduct + "&DifferencePer=" + DifferencePer + "&DifferenceBath=" + DifferenceBath + "&price=" + price + "&total_price=" + total_price + "&total=" + total + "&type=" + type;
                                alert(p);
                                $.get("action_editProduct.php?p=addProduct" + p, function (data, status) {
                                    alert("Data: " + data + "\nStatus: " + status);
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
                                });
                            }

</script>