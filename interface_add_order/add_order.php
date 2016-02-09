<?php
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_order';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
require_once '/function/func_addorder.php';
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
            //alert('<?= getShop2(); ?>');
            var data = JSON.stringify(<?php echo getShop2(); ?>);
            alert(data);
            var www = JSON.parse(data);
            //data = JSON.parse(www+'');
            /*alert(data);*/
            //document.write(www[0].idshop+www[0].name_shop);
            var shopName = new Array();
            var shopId = new Array();

            for (var i = 0; i < www.length; i++) {
                //var obj = JSON.parse(item);
                //shopName[i++] = item["shop_name"];
                // shopId[i++] = item["idshop"];
                alert(www[i].name_shop);
                shopName.push(www[i].name_shop);
                shopId["'" + www[i].name_shop + "'"] = www[i].idshop;
                //alert(item["shop_name"]);

            }
            //alert(data);
            $(function () {

                $("#code_order").autocomplete({
                    source: shopName
                });
            });
            function getShopId() {
            alert("Hello");
              var price = document.getElementById("code_order").value;
                
        alert(shopId["'"+price+"'"]);

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
                                <h2> Add Order </h2>   
                                <h5> เพิ่มคำสั่งซื้อ </h5>

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
                                                <div>
                                                    <label for="disabled_no">No.บิล</label>
                                                    <input type="text" class="form-control" id="code_order" name="code_order" placeholder="ID บิล" autocomplete= on onblur="getShopId()">
                                                </div>
                                                <p id="www"></p>
                                                <div >
                                                    <p>วันที่สั่งซื้อ <input type="date" class="form-control" id ="date_order" name="date_order"></p>
                                                    <input type="time" class="form-control" id ="time_order" name="time_order">
                                                </div>
                                                <div>
                                                    <label for="disabled_shop">ชื่อร้านค้า</label>
                                                    <select class="form-control" id="idshop" name ="idshop"required >
                                                        <option selected value="">Choose</option>
                                                        <?php
                                                        require_once '/function/func_addorder.php';
                                                        $getShop = getShop();

                                                        foreach ($getShop as $value) {
                                                            $val_idshop = $value['idshop'];
                                                            $val_name_shop = $value['name_shop'];
                                                            ?>
                                                            <option value="<?php echo $val_idshop; ?>"><?php echo $val_name_shop; ?></option>
                                                        <?php } ?>
                                                    </select>
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

                                                <a href="popup_addproduct_order.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                                    <span class="glyphicon glyphicon-plus"></span> เพิ่มสินค้า </a>
                                                <div id="showUnit"></div>

                                            </div>

                                        </div>
                                    </div>
                                    <!--End  ตารางสินค้าที่สั่งซื้อ --> 
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="form-group col-xs-8">
                                            <label for="exampleInputName2">รายละเอียดเพิ่มเติม</label>
                                            <textarea rows="4" cols="50" id = "detail_order" name ="detail_order" class="form-control" placeholder="กรอกรายละเอียดเพิ่มเติม" value=""></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>                              
                                        <button type="submit" class="btn btn-info btn-lg text-center">
                                            <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                                        </button>
                                        <a href="add_order.php" class="btn btn-danger btn-lg text-center">
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
                                                        $(document.body).on('hidden.bs.modal', function () {
                                                            $('#myModal').removeData('bs.modal');
                                                        });</script>
<script>
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