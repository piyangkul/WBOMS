<?php
session_start();
require_once '/function/func_addorder.php';
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_order';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
date_default_timezone_set("Asia/Bangkok");
if (isset($_SESSION['date'])) {
    $date = $_SESSION['date'];
} else {
    $date = date("Y-m-d");
}
if (isset($_SESSION['date'])) {
    $var = $_SESSION['time'];
} else {
    $var = date('H:i');
}
$idshop = 0;
$detail = "";
$nameshop = "";
if (isset($_SESSION['idshop'])) {
    $idshop = $_SESSION['idshop'];
    $getShopAdd_Order = getShopAdd_Order($idshop);
    $nameshop = $getShopAdd_Order['name_shop'];
}if (isset($_SESSION['detail'])) {
    $detail = $_SESSION['detail'];
}

/* if (isset($_GET['idshop'])) {
  $idshop = $_GET['idshop'];
  $getShopAdd_Order = getShopAdd_Order($idshop);
  $nameshop = $getShopAdd_Order['name_shop'];
  } */
//$t=time("");
//echo $t;
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
                var idshop = shopId["'" + price + "'"];


                $.ajax({type: "GET",
                    url: "action/action_session.php",
                    async: false,
                    data: "idshop=" + idshop,
                    dataType: 'html',
                    success: function ()
                    {
                    }
                });

            }
            function s_date() {
                var date = document.getElementById("date_order").value;
                $.ajax({type: "GET",
                    url: "action/action_session.php",
                    async: false,
                    data: "date=" + date,
                    dataType: 'html',
                    success: function ()
                    {
                    }
                }
                );
            }
            function s_time(){
                var time = document.getElementById("time_order").value;
                $.ajax({type: "GET",
                    url: "action/action_session.php",
                    async: false,
                    data: "time=" + time,
                    dataType: 'html',
                    success: function ()
                    {
                    }
                }
                );
            }
            function s_detail(){
                var detail = document.getElementById("detail_order").value;
                $.ajax({type: "GET",
                    url: "action/action_session.php",
                    async: false,
                    data: "detail=" + detail,
                    dataType: 'html',
                    success: function ()
                    {
                    }
                }
                );
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
                                                <div>
                                                    <label for="disabled_shop">ชื่อร้านค้า</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-shopping-cart"  ></i></span>
                                                        <input type="text" class="form-control" id="name_shop" name="name_shop" placeholder="กรุณาระบุชื่อร้านค้า" autocomplete= on onblur="getShopId()" value="<?= $nameshop; ?>"></input>        
                                                    </div>
                                                    <input type="hidden" id="idshop" name="idshop" value="<?= $idshop; ?>"></input>
                                                </div>
                                                <label>วันที่สั่งซื้อ </label>
                                                <div class="input-group">                                         
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                    <input type="date" class="form-control" id ="date_order" name="date_order" value="<?= $date; ?>" onblur="s_date()"/>
                                                    <input type="time" class="form-control" id ="time_order" name="time_order" value="<?= $var ?>" onblur="s_time()"></input>
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
                                                <a class="btn btn-info btn-lg" onclick="addProduct_Order()">
                                                    <span class="glyphicon glyphicon-plus"></span> เพิ่มสินค้า
                                                </a>
                                                <button class="btn btn-danger btn-lg" type="button" onclick="if (confirm('คุณต้องการลบหน่วยสินค้าทั้งหมดหรือไม่')) {
                                                            resetUnit();
                                                        }">
                                                    <span class="glyphicon glyphicon-trash"></span> ลบสินค้าทั้งหมด
                                                </button>
                                                <br></br>
                                                <div id="showUnit"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End  ตารางสินค้าที่สั่งซื้อ --> 
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="form-group col-xs-8">
                                            <label for="exampleInputName2">รายละเอียดเพิ่มเติม</label>
                                            <textarea rows="4" cols="50" id = "detail_order" name ="detail_order" class="form-control" placeholder="กรอกรายละเอียดเพิ่มเติม" onblur="s_detail()"><?= $detail; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>                              

                                        <a href="action/action_reset.php?cancel=cancel" class="btn btn-danger btn-lg text-center">
                                            <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                                        </a>
                                        <button type="submit" class="btn btn-info btn-lg text-center">
                                            <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                                        </button>
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
                                                function resetUnit() {
                                                    $.get("action_addProduct.php?p=resetUnit", function (data, status) {
                                                        if (data != "-1") {
                                                            showUnit();
                                                            getBigestUnit();
                                                            getBigestPrice();
                                                            alert("ลบหน่วยทั้งหมดแล้ว");
                                                        }
                                                        else {
                                                            alert("ไม่สามารถลบหน่วยได้");

                                                        }
                                                    });
                                                }
                                                function addProduct_Order() {
                                                    if (document.getElementById("name_shop").value.length > 0) {
                                                        var idshop = document.getElementById("idshop").value;
                                                        var detail = document.getElementById("detail_order").value;
                                                        var date = document.getElementById("date_order").value;
                                                        var time = document.getElementById("time_order").value
                                                        window.location.href = 'addproduct_addorder.php?idshop=' + idshop + "&detail=" + detail + "&date=" + date + "&time=" + time;
                                                    }
                                                    else {
                                                        alert("กรุณากรอกชื่อร้านค้า");
                                                    }
                                                }


</script>