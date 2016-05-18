<?php
require_once 'function/func_stat.php';
require_once '../shipment/function/func_shipment.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'stat';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
$year_start = $_GET['year_start'];
$month_start = $_GET['month_start'];
$year_end = $_GET['year_end'];
$month_end = $_GET['month_end'];

//if (isset($_GET['get_year_start'])) {
//    $year_start = $_GET['get_year_start'];
//    $month_start = $_GET['get_month_start'];
//    $year_end = $_GET['get_year_end'];
//    $month_end = $_GET['get_month_end'];
//}
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
        <script src="../assets/js/jquery-1.10.2.js"></script>

        <script src="../high_chart_table/highchartTable-min.js" type="text/javascript"></script>
        <script src="../high_chart_table/highchartTable.js" type="text/javascript"></script>

<!--        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>-->

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
                            <h2> Statistic </h2>   
                            <h5> สถิติการเงิน </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr/>
                    <a class="btn btn-danger btn-lg" onclick="Back()"><span class="fa fa-arrow-circle-left"></span> Back</a>
                    <br/>
                    <!-- ข้อมูลการเงินรายเดือน-ปี -->
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    <!-- End ข้อมูลการเงินรายเดือน-ปี -->
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. WRAPPER  -->
        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
<!--        <script src="../assets/js/jquery-1.10.2.js"></script>-->
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <pre>
            <?php
            $getIncome_Outcome_JSON = getIncome_Outcome_JSON($month_start, $year_start, $month_end, $year_end);
            $getIncome_Outcome = getIncome_Outcome($month_start, $year_start, $month_end, $year_end);
//        $getIncome_Outcome_total = getIncome_Outcome_total($getIncome_Outcome);
//        print_r($getIncome_Outcome_total);
            $getIncome_Outcome_total_JSON = getIncome_Outcome_total_JSON($getIncome_Outcome);
            //print_r($getIncome_Outcome_total_JSON);
            ?>
        </pre>
        <script>
                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip();
                            $('table.highchart').highchartTable();
                        });

                        var idshop;
                        var data = JSON.stringify(<?php echo $getIncome_Outcome_total_JSON; ?>);//ดึงค่า
                        var Obj = JSON.parse(data);//Objตามจำนวนข้อมูล
                        //alert(Obj);
                        var Arr_idperiod = new Array();
                        var Arr_period = new Array();
                        var Arr_income = new Array();
                        var Arr_outcome = new Array();
                        var Arr_profit = new Array();
                        //var Arr_all_outcome = new Array();
                        var Arr_outcome_lack = new Array();
                        var Arr_income_lack = new Array();
                        //pushข้อมูลลงArray
                        for (var i = 0; i < Obj.length; i++) {
                            //Arr_idperiod.push(Obj[i].idshipment_period);
                            Arr_period.push(Obj[i].date_start + ' ถึง ' + Obj[i].date_end);
                            Arr_income.push(Obj[i].income);
                            Arr_outcome.push(Obj[i].outcome);
                            //Arr_all_outcome.push(Obj[i].all_outcome);
                            Arr_outcome_lack.push(Obj[i].all_outcome - Obj[i].outcome);
                            Arr_income_lack.push(Obj[i].all_income - Obj[i].income);
                            Arr_profit.push(Obj[i].income - Obj[i].outcome);
                            console.log(Arr_income);


                            $(function () {
                                $('#container').highcharts({
                                    chart: {
                                        type: 'column',
                                        width: '1000',
                                        height: '550'
                                    },
                                    colors: ["#96c3ef", "#536a85", "#90ee7e", "#3b8529", "#f7a35c"],
                                    title: {
                                        text: 'กราฟแสดงข้อมูลการเงินรายเดือน-ปี'
                                    },
                                    xAxis: {
                                        categories: Arr_period
                                    },
                                    yAxis: {
                                        allowDecimals: false,
                                        min: -1,
                                        title: {
                                            text: 'จำนวนเงิน (บาท)'
                                        }
                                    },
                                    tooltip: {
                                        formatter: function () {
                                            return '<b>' + this.x + '</b><br/>' +
                                                    this.series.name + ': ' + this.y + '<br/>' +
                                                    'Total: ' + this.point.stackTotal;
                                        }
                                    },
                                    plotOptions: {
                                        column: {
                                            stacking: 'normal'
                                        }
                                    },
                                    series: [{
                                            name: 'รายรับคงค้าง(ยังไม่ได้เก็บร้านค้า)',
                                            data: Arr_income_lack,
                                            stack: 'income'
                                        }, {
                                            name: 'รายรับจริง',
                                            data: Arr_income,
                                            stack: 'income'
                                        }, {
                                            name: 'รายจ่ายคงค้าง(ยังไม่ได้จ่ายโรงงาน)',
                                            data: Arr_outcome_lack,
                                            stack: 'outcome'
                                        }, {
                                            name: 'รายจ่ายจริง',
                                            data: Arr_outcome,
                                            stack: 'outcome'
                                        }, {
                                            name: 'กำไร/ขาดทุนจริง',
                                            data: Arr_profit,
                                            stack: 'profit'
                                        }]
                                });
                            });
                        }
                        function Back() {
                            window.location.assign("stat.php?year_start=<?php echo $year_start; ?>&month_start=<?php echo $month_start; ?>&year_end=<?php echo $year_end; ?>&month_end=<?php echo $month_end; ?>");
                        }
        </script>
        <script>
            $(document).ready(function () {
            $('#dataTables-example').dataTable();
////                $.post('../shipment/function/func_shipment.php', {idshipment_period: Arr_idperiod}, function (data) {
////                    alert(data);
////                });
//                $.get('../shipment/function/func_shipment.php?idshipment_period=' + Arr_idperiod, function (data, status) {//+"&id="+
//                    //$("#show_send_table").html(data);
//                    alert(data);
//                });
//            });
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
