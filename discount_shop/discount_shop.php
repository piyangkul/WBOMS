﻿<?php
require_once 'function/func_discount_shop.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'discount_shop';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
<?php
// ตอนส่งค่ากลับ
if (isset($_GET['idproduct'])) {
    $idshop = $_GET['idproduct'];
//    $getShopsByID = getShopsByID($idshop);
//    $val_shop_code = $getShopsByID['shop_code'];
//    $val_name_shop = $getShopsByID['name_shop'];
//    $data_search_shop = $val_name_shop . ' (' . $val_shop_code . ')';
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
            var idproduct;
            var data = JSON.stringify(<?php echo getProductByName_JSON(); ?>);//ดึงค่า
            var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
            //alert(Obj);
            var Arr = new Array();
            var JSON_productCode = new Array();
            var JSON_productName = new Array();
            var JSON_factoryName = new Array();
            //pushข้อมูลลงArray
            for (var i = 0; i < Obj.length; i++) {
                //Arr.push(Obj[i].code_factory);
                Arr.push("[" + Obj[i].product_code + "] " + Obj[i].name_product + " - "+ Obj[i].name_factory);
                JSON_productCode["'" + Obj[i].product_code + "'"] = Obj[i].idproduct;
                JSON_productName["'" + Obj[i].name_product + "'"] = Obj[i].idproduct;
                JSON_factoryName["'" + Obj[i].name_factory + "'"] = Obj[i].idproduct;
                console.log(JSON_productCode);
                console.log(JSON_productName);
                console.log(JSON_factoryName);
            }

            $(function () { // document ready
                $("#searchProduct").autocomplete({
                    source: Arr
                });
                // ตอนส่งค่ากลับ
//                text_shop = "";
//                text_shop = '<?php echo ((isset($data_search_shop) && $data_search_shop != "") ? $data_search_shop : ""); ?>';
//                if (text_shop != "")
//                {
//                    shopNode = document.getElementById("searchProduct");
//                    shopNode.value = text_shop;
//                    shopNode.focus();
//                    shopNode.blur();
//                }

            });

            function getProductId(e) {
                if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {
                    var input = document.getElementById("searchProduct").value;
                    //alert(input);
                    firstParen = input.lastIndexOf("[");
                    secondParen = input.lastIndexOf("]");
                    input = input.substr(firstParen + 1, secondParen - firstParen - 1);
                    //alert(input+ firstParen +","+ secondParen);
                    if (JSON_productCode["'" + input + "'"] != null) {
                        idproduct = JSON_productCode["'" + input + "'"];
                    }
                    else {
                        idproduct = JSON_productName["'" + input + "'"];
                    }
                    console.log(idproduct);
                    show_cost_product_table();
                    show_discount_shop_table();
                }
                return false;
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
                    <div class="row">
                        <div class="col-md-12">
                            <h2> Discount Shop </h2>   
                            <h5> ประวัติส่วนลดร้านค้าล่าสุด </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />

                    <!-- ค้นหา -->
                    <div class="row">
                        <div class="col-md-3"></div>                        
                        <div class="col-md-6 "> 
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <div class="table-responsive"> 
                                        
                                        <div class="form-group">
                                            <label for="product_code">ค้นหารหัสหรือชื่อสินค้า</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                                                <input type="text" class="form-control" id="searchProduct" name="searchProduct" autocomplete=on placeholder="กรอกรหัสหรือชื่อสินค้า" onblur ="getProductId(event)" onkeypress="getProductId(event)" />
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End ค้นหา -->
                    <br/>
                    <!-- ข้อมูลต้นทุนสินค้า -->
                    <div class="row">
                        <div class="col-md-3"></div>                        
                        <div class="col-md-6 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>ข้อมูลต้นทุนสินค้า</label>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_cost_product_table">
                                        <!-- show_cost_product_table, action_cost_product_show -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End ข้อมูลต้นทุนสินค้า -->
                    <br/>
                    <!-- ส่วนลดร้านค้า -->
                    <div class="row">
                        <div class="col-md-2"></div>                        
                        <div class="col-md-8 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>ส่วนลดร้านค้า</label>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_discount_shop_table">
                                        <!-- show_discount_shop_table, action_discount_shop_show-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End ส่วนลดร้านค้า -->

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
            show_cost_product_table();
            function show_cost_product_table() {
                $.get("action/action_cost_product_show.php?idproduct=" + idproduct, function (data, status) {//+"&id="+
                    $("#show_cost_product_table").html(data);
                });
            }
            
            show_discount_shop_table();
            function show_discount_shop_table() {
                $.get("action/action_discount_shop_show.php?idproduct=" + idproduct, function (data, status) {//+"&id="+
                    $("#show_discount_shop_table").html(data);
                });
            }
        </script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal');
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