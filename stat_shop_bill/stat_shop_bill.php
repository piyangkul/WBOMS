<?php
require_once 'function/func_stat_shop_bill.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'stat_shop_bill';
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
            var idyear;
            var data = JSON.stringify(<?php echo getYaer(); ?>);//ดึงค่า
            var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
            //alert(Obj);
            var Arr = new Array();
            var JSON_A_D = new Array();
            var JSON_B_E = new Array();
            //pushข้อมูลลงArray
            for (var i = 0; i < Obj.length; i++) {
                //Arr.push(Obj[i].code_factory);
                Arr.push(Obj[i].B_E + " ( ค.ศ. " + Obj[i].A_D + " )");
                JSON_A_D["'" + Obj[i].B_E + "'"] = Obj[i].IDyear;
                JSON_B_E["'" + Obj[i].A_D + "'"] = Obj[i].IDyear;
                console.log(JSON_A_D);
                console.log(JSON_B_E);
            }
            $(function () {
                $("#code").autocomplete({
                    source: Arr
                });
            });

            function getFactoryId(e) {
                //alert(e);
                //alert(e.keyCode);
                if ((e instanceof FocusEvent) || (e instanceof KeyboardEvent && e.keyCode === 13)) {//$('#myText').live("keypress", function(e) {
                    //alert("go");
                    var input = document.getElementById("code").value;
                    //alert(input);
                    firstParen = input.lastIndexOf("(");
                    secondParen = input.lastIndexOf(")");
                    input = input.substr(firstParen + 7, secondParen - firstParen - 8);
                    //alert(input+ firstParen +","+ secondParen);
                    if (JSON_A_D["'" + input + "'"] != null) {
                        idyear = JSON_A_D["'" + input + "'"];
                    }
                    else {
                        idyear = JSON_B_E["'" + input + "'"];
                    }
                    console.log(idyear);
                    show_stat_shop_table();
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
                            <h2> Statistic Shop Bill </h2>   
                            <h5> สถิติการก็บเงินร้านค้า </h5>
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
                                            <label for="name_factory">ค้นหาปี</label>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar" ></i></span>
                                                <input type="text" class="form-control" id="code" autocomplete=on name="code" placeholder="กรอกรหัสหรือชื่อโรงงาน" onblur ="getFactoryId(event)" onkeypress="getFactoryId(event)">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End ค้นหา -->

                    <div class="row">
                        <div class="col-md-12">                          
                            <br/><br/>
                            <!-- ตารางข้อมูลการเก็บเงินร้านค้ารายปี -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางข้อมูลการเก็บเงินร้านค้ารายปี</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_stat_shop_table">
                                        <!--show_stat_shop_table--> 
                                    </div>
                                </div>
                            </div>
                            <!-- End ตารางข้อมูลการเก็บเงินร้านค้ารายปี -->
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
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal');
            });
        </script>
        <script>
            show_stat_shop_table();
            function show_stat_shop_table() {
                $.get("action/action_stat_shop_show.php?idyear=" + idyear, function (data, status) {
                    $("#show_stat_shop_table").html(data);
                });
            }
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