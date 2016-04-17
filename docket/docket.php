<?php
require_once 'function/func_docket.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'docket';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
?>
<?php
if (isset($_GET['idshop'])) {
    $idshop = $_GET['idshop'];
    $getShopsByID = getShopsByID($idshop);
    $val_shop_code = $getShopsByID['shop_code'];
    $val_name_shop = $getShopsByID['name_shop'];
    $data_search_shop = $val_name_shop . ' (' . $val_shop_code . ')';
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
            var idshop;
            var data = JSON.stringify(<?php echo getShopsJSON(); ?>);//ดึงค่า
            var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
            //alert(Obj);
            var Arr = new Array();
            var JSON_shopCode = new Array();
            var JSON_shopName = new Array();
            //pushข้อมูลลงArray
            for (var i = 0; i < Obj.length; i++) {
                //Arr.push(Obj[i].code_factory);
                Arr.push(Obj[i].name_shop + " (" + Obj[i].shop_code + ")");
                JSON_shopCode["'" + Obj[i].shop_code + "'"] = Obj[i].idshop;
                JSON_shopName["'" + Obj[i].name_shop + "'"] = Obj[i].idshop;
                console.log(JSON_shopCode);
                console.log(JSON_shopName);
            }

            $(function () { // document ready
                $("#shop").autocomplete({
                    source: Arr
                });

                text_shop = "";
                text_shop = '<?php echo ((isset($data_search_shop) && $data_search_shop != "") ? $data_search_shop : ""); ?>';
                if (text_shop != "")
                {
                    shopNode = document.getElementById("shop");
                    shopNode.value = text_shop;
                    shopNode.focus();
                    shopNode.blur();
                }

            });

            function getShopId(e) {
                if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {
                    var input = document.getElementById("shop").value;
                    //alert(input);
                    firstParen = input.lastIndexOf("(");
                    secondParen = input.lastIndexOf(")");
                    input = input.substr(firstParen + 1, secondParen - firstParen - 1);
                    //alert(input+ firstParen +","+ secondParen);
                    if (JSON_shopCode["'" + input + "'"] != null) {
                        idshop = JSON_shopCode["'" + input + "'"];
                    }
                    else {
                        idshop = JSON_shopName["'" + input + "'"];
                    }
                    console.log(idshop);
                    show_docket_table();
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
                            <h2> Shop Bill </h2>   
                            <h5> การเก็บเงินร้านค้า </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <span>
                        <?php
                        if (isset($_GET['action'])) {
                            if ($_GET['action'] == "addPayshopCompleted") {
                                echo '<center><h4 class="alert alert-success">คุณได้ทำการเพิ่มการเก็บเงินร้านค้าสำเร็จแล้ว</h4></center>';
                            } else if ($_GET['action'] == "addPayshopError") {
                                echo '<center><h4 class="alert alert-danger">ผิดพลาด!! ไม่สามารถเพิ่มการเก็บเงินร้านค้าได้</h4></center>';
                            } else if ($_GET['action'] == "delPayshopCompleted") {
                                echo '<center><h4 class="alert alert-success">คุณได้ทำการลบการเก็บเงินร้านค้าสำเร็จแล้ว</h4></center>';
                            } else if ($_GET['action'] == "delPayshopError") {
                                echo '<center><h4 class="alert alert-danger">ผิดพลาด!! ไม่สามารถลบการเก็บเงินร้านค้าได้</h4></center>';
                            } else if ($_GET['action'] == "finishPayshopCompleted") {
                                echo '<center><h4 class="alert alert-success">คุณได้ทำการเปลี่ยนสถานะเก็บเงินร้านค้าเป็นเสร็จสิ้นสำเร็จแล้ว</h4></center>';
                            } else if ($_GET['action'] == "finishPayshopError") {
                                echo '<center><h4 class="alert alert-danger">ผิดพลาด!! ไม่สามารถเปลี่ยนสถานะเก็บเงินร้านค้าเป็นเสร็จสิ้นได้</h4></center>';
                            } else if ($_GET['action'] == "addPayshop_shipment_Error") {
                                echo '<center><h4 class="alert alert-danger">ผิดพลาด!! ไม่สามารถเปลี่ยนสถานะเก็บเงินร้านค้าเป็นเสร็จสิ้นได้ เนื่องจากวันที่เริ่มและสิ้นสุดไม่อยู่เดือนเดียวกัน</h4></center>';
                            }
                        }
                        ?>
                    </span>
                    <div class="alert alert-success" role="alert"><b>คำชี้แจง</b> : กรุณาพิมพ์ใบแจ้งหนี้ และเพิ่มข้อมูลการเก็บเงินร้านค้า
                        <br/><b>หมายเหตุ</b> : รอบไหนที่ไม่มีการสั่งซื้อ แต่มีสินค้าคืนจากรอบก่อนหน้า ให้ถือว่ารอบนั้นเก็บไม่ได้ 
                        <br/>1.กรณีถ้าร้านค้าไม่ได้เลิกกิจการ --> ระบบจะมองว่ารอบนั้นขาดทุน และจะเก็บในรอบถัดไป  
                        <br/>2.กรณีถ้าร้านค้าเลิกกิจการ --> ระบบจะมองว่ารอบนั้นขาดทุน
                    </div>
                    <!-- ค้นหา -->
                    <div class="row">
                        <div class="col-md-3"></div>                        
                        <div class="col-md-6 "> 
                            <div class="panel panel-default">
                                <div class="panel-heading ">
                                    <div class="table-responsive">
                                        <div class="form-group">
                                            <label for="name_shop">ค้นหารหัสหรือชื่อร้านค้า</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-shopping-cart" ></i></span>
                                                <input type="text" class="form-control" id="shop" autocomplete=on name="shop" placeholder="กรอกรหัสหรือชื่อร้านค้า" onblur ="getShopId(event)" onkeypress="getShopId(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End ค้นหา -->
                    <!-- ข้อมูลการจ่ายเงินโรงงานรายเดือน-ปี -->
                    <div class="row">
                        <!--<div class="col-md-1"></div>-->                        
                        <div class="col-md-12 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ข้อมูลการเก็บเงินร้านค้ารายเดือน-ปี</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_docket_table">
                                        <!--show_docket_table--> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End ข้อมูลการจ่ายเงินโรงงานรายเดือน-ปี -->

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
            show_docket_table();
            function show_docket_table() {
                $.get("action/action_docket_show.php?idshop=" + idshop, function (data, status) {//+"&id="+
                    $("#show_docket_table").html(data);
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
        <div class="modal-content modal-lg ui-front">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-sm ui-front">
            <!-- Content -->
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ui-front">
            <!-- Content -->
        </div>
    </div>
</div>
<!--<div class="alert alert-danger" role="alert">1.รง.ไทยฟูดส์เพี้ยน </div>-->