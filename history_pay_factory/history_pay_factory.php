<?php
require_once 'function/func_history_pay_factory.php';
require_once '../docket/function/func_docket.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_pay_factory';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <script src="//code.jquery.com/jquery-1.10.2.js"></script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <script>
                var idfactory;
                var data = JSON.stringify(<?php echo getFactory(); ?>);//ดึงค่า
                var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
                //alert(Obj);
                var Arr = new Array();
                var JSON_factoryCode = new Array();
                var JSON_factoryName = new Array();
                //pushข้อมูลลงArray
                for (var i = 0; i < Obj.length; i++) {
                    //Arr.push(Obj[i].code_factory);
                    Arr.push(Obj[i].name_factory + " (" + Obj[i].code_factory + ")");
                    JSON_factoryCode["'" + Obj[i].code_factory + "'"] = Obj[i].idfactory;
                    JSON_factoryName["'" + Obj[i].name_factory + "'"] = Obj[i].idfactory;
                    console.log(JSON_factoryCode);
                    console.log(JSON_factoryName);
                }
                $(function () {
                    $("#code_order").autocomplete({
                        source: Arr
                    });
                });

                function getFactoryId(e) {//ใช้กับ<input type="text" id="code_order" autocomplete=on name="code_order" onkeypress="getShopId(event)"  >
                    //alert(e);
                    //alert(e.keyCode);
                    if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {//$('#myText').live("keypress", function(e) {
                        //alert("go");
                        var input = document.getElementById("code_order").value;
                        //alert(input);
                        firstParen = input.lastIndexOf("(");
                        secondParen = input.lastIndexOf(")");
                        input = input.substr(firstParen + 1, secondParen - firstParen - 1);
                        //alert(input+ firstParen +","+ secondParen);
                        if (JSON_factoryCode["'" + input + "'"] != null) {
                            idfactory = JSON_factoryCode["'" + input + "'"];
                        }
                        else {
                            idfactory = JSON_factoryName["'" + input + "'"];
                        }
                        console.log(idfactory);
                        //$("#test").text(idfactory);
                        show_pay_factory_table();
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
                            <h2> History Pay Factory </h2>   
                            <h5> ประวัติการจ่ายเงินโรงงาน </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <!--<div class="alert alert-danger" role="alert">แก้ 1.sqlสินค้าคืน </div>-->
                    <div class="container col-md-12">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a data-toggle="tab" href="#tab_factory">ค้นหาโรงงาน</a></li>
                            <li><a data-toggle="tab" href="#tab_shipment_period">ค้นหารอบการส่ง</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab_factory" class="tab-pane fade in active">
                                </br>
                                <!-- ค้นหา -->
                                <div class="row">
                                    <div class="col-md-3"></div>                        
                                    <div class="col-md-6 "> 
                                        <div class="panel panel-default">
                                            <div class="panel-heading ">
                                                <div class="table-responsive">                                          
                                                    <div class="form-group">
                                                        <label for="name_factory">ค้นหารหัสหรือชื่อโรงงาน</label>
                                                        <div class="form-group input-group">
                                                            <span class="input-group-addon"><i class="fa fa-building-o" ></i></span>
                                                            <input type="text" class="form-control" id="code_order" autocomplete=on name="code_order" placeholder="กรอกรหัสหรือชื่อโรงงาน" onblur ="getFactoryId(event)" onkeypress="getFactoryId(event)">
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
                                    <div class="col-md-1"></div>                        
                                    <div class="col-md-10 ">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4>ข้อมูลการจ่ายเงินโรงงานรายเดือน-ปี</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive" id="show_pay_factory_table">
                                                    <!--show_pay_factory_table--> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End ข้อมูลการจ่ายเงินโรงงานรายเดือน-ปี -->
                            </div>

                            <div id="tab_shipment_period" class="tab-pane fade">
                                </br>
                                <!-- ค้นหา -->
                                <div class="row">
                                    <div class="col-md-3"></div>                        
                                    <div class="col-md-6"> 
                                        <div class="panel panel-default">
                                            <div class="panel-heading ">
                                                <div class="table-responsive">
                                                    <div class="form-group">
                                                        <!--<span class="col-md-0"> </span>-->
                                                        <label for="search_shipment_period">เลือกรอบการส่ง</label>
                                                        <span class="col-md-offset-5"> </span>

                                                        <div class="form-group input-group">
                                                            <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                            <select id="idshipment" class="form-control" onchange="show_factory_table_period()" >
                                                                <?php
                                                                $getShipment = getShipment();
                                                                $num = sizeof($getShipment) + 1;
                                                                foreach ($getShipment as $value) {
                                                                    $num--;
                                                                    $idshipment = $value['idshipment_period'];
                                                                    $date_start = $value['date_start'];
                                                                    $date_end = $value['date_end'];
                                                                    echo "<option  value = $idshipment> รอบที่$num : $date_start ถึง $date_end </option>";
                                                                }
                                                                ?>                                                              
                                                            </select>
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
                                    <div class="col-md-1"></div>                        
                                    <div class="col-md-10 ">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h4>ข้อมูลการเก็บเงินร้านค้าประจำรอบ</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive" id="show_factory_table_period">
                                                    <!--show_docket_table_period--> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End ข้อมูลการจ่ายเงินโรงงานรายเดือน-ปี -->
                            </div>

                        </div>
                    </div>
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
            show_factory_table_period();
            function show_factory_table_period() {
                var idshipment = document.getElementById('idshipment').value;
                $.get('action/action_factory_period_show.php?idshipment_period=' + idshipment, function (data, status) {//+"&id="+
                    $("#show_factory_table_period").html(data);
                });
            }
        </script>
        <script>
            show_pay_factory_table();
            function show_pay_factory_table() {
                //var idfactory = $("#test").val();
                $.get("action/action_pay_factory_show.php?idfactory=" + idfactory, function (data, status) {
                    $("#show_pay_factory_table").html(data);
                });
            }
        </script>
        <script>
            //            show_pay_factory_table();
            //            function show_pay_factory_table() {
            //                    var idfactory = $("#idFactory").val();
            //                $.get("action/action_pay_factory_show.php?idfactory=" + idfactory, function (data, status) {
            //            $("#show_pay_factory_table").html(data);
            //            });
            //            }

            //            searchFactory();
            //            function searchFactory() {
            //                var searchFactory = $("#searchFactory").val();
            //                $.get("history_search_pay_factory.php?searchFactory=" + searchFactory, function (data, status) {
            //                    $("#idFactory").html(data);
            //                    show_pay_factory_table();
            //                });
            //            }

            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal-lg').removeData('bs.modal');
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
<!--<div class="alert alert-danger" role="alert">1.รง.ไทยฟูดส์เพี้ยน </div>-->