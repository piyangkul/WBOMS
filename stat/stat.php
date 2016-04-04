<?php
require_once 'function/func_stat.php';
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'stat';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
if (isset($_GET['year_start'])) {
    $get_year_start = $_GET['year_start'];
    $get_month_start = $_GET['month_start'];
    $get_year_end = $_GET['year_end'];
    $get_month_end = $_GET['month_end'];
} else {
    $get_year_start = 0;
    $get_month_start = 0;
    $get_year_end = 0;
    $get_month_end = 0;
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
        <!--        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
                <script src="//code.jquery.com/jquery-1.10.2.js"></script>
                <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->

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
                            <h2> Statistic Finance </h2>   
                            <h5> สถิติการเงิน </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />
                    <!--<div class="alert alert-danger" role="alert">แก้:filer เดือน-ปี</div>-->

                    <!-- ค้นหา -->
                    <div class="row">
                        <!--<div class="col-md-3"></div>-->                        
                        <div class="col-md-6 "> 
                            <div class="form-group">
                                <h4 for="start" class="text-center">ค้นหาช่วงเวลาเริ่มต้น</h4>
                                <div class="panel panel-default">                             
                                    <div class="panel-heading" >
                                        <div class="table-responsive">

                                            <div class="form-group">
                                                <label for="year_start">เลือกปีเริ่มต้น</label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                    <select class="form-control" id="year_start" name="year_start"  onchange="search_YearEnd();"></select>
                                                    <!--<select class="form-control hidden" id="year_start_hidden" name="year_start"  onchange="search_YearEnd();"></select>-->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="month_start">เลือกเดือนเริ่มต้น</label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                    <select class="form-control" id="month_start" name="month_start" onchange="
                                                            search_YearEnd();
                                                            search_MonthEnd();"></select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 "> 
                            <div class="form-group">
                                <h4 for="end" class="text-center">ค้นหาช่วงเวลาสิ้นสุด</h4>
                                <div class="panel panel-default">                             
                                    <div class="panel-heading" >
                                        <div class="table-responsive">

                                            <div class="form-group">
                                                <label for="year_end">เลือกปีสิ้นสุด</label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                    <select class="form-control" id="year_end" name="year_end" onchange="search_MonthEnd();"></select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="month_end">เลือกเดือนสิ้นสุด</label>
                                                <div class="form-group input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar-o" ></i></span>
                                                    <select class="form-control" id="month_end" name="month_end" onchange="show_stat_table();"></select>
                                                </div>
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
                            <button class="btn btn-warning btn-lg" onclick="go_to_chart()">
                                <span class="fa fa-bar-chart"></span> Chart
                            </button>

                            <br/>
                            <br/>
                            <!-- ข้อมูลการเงินรายเดือน-ปี -->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>ตารางข้อมูลการเงินรายเดือน-ปี</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="show_stat_table">
                                        <!-- show_stat_table -->
                                    </div>
                                </div>
                            </div>
                            <!-- End ข้อมูลการเงินรายเดือน-ปี -->
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
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
                                $(document).ready(function () {
                                    $('#dataTables-example').dataTable({"sort": false});
                                });</script>
        <script>
            search_start();
            function search_start() {
                var get_year_start = "<?php echo $get_year_start; ?>";
                var get_month_start = "<?php echo $get_month_start; ?>";
                $.get('stat_search_year_start.php?get_year_start=' + get_year_start, function (data, status) {
                    //console.log(year_start);
                    $("#year_start").html(data);
                    //show_stat_table();
                });
                $.get("stat_search_month_start.php?get_month_start=" + get_month_start, function (data, status) {
                    $("#month_start").html(data);
                    //show_stat_table();
                });
                //show_stat_table();
            }

            search_YearEnd();
            function search_YearEnd() {
                var get_year_end = "<?php echo $get_year_end; ?>";
                var year_start = $("#year_start").val();
                var month_start = $("#month_start").val();
                $.get('stat_search_year_end.php?year_start=' + year_start + '&month_start=' + month_start + '&get_year_end=' + get_year_end, function (data, status) {
                    $("#year_end").html(data);
                    //show_stat_table();
                });
            }
            
            search_MonthEnd();
            function search_MonthEnd() {
                var get_month_end = "<?php echo $get_month_end; ?>";
                var year_start = $("#year_start").val();
                var month_start = $("#month_start").val();
                var year_end = $("#year_end").val();
                //console.log(month_start);
                $.get('stat_search_month_end.php?year_start=' + year_start + '&month_start=' + month_start + '&year_end=' + year_end + '&get_month_end=' + get_month_end, function (data, status) {
                    $("#month_end").html(data);
                    //show_stat_table();
                });
            }

            show_stat_table();
            function show_stat_table() {
                var get_year_start = "<?php echo $get_year_start; ?>";
                var get_month_start = "<?php echo $get_month_start; ?>";
                var get_year_end = "<?php echo $get_year_end; ?>";
                var get_month_end = "<?php echo $get_month_end; ?>";
                var year_start = $("#year_start").val();
                var month_start = $("#month_start").val();
                var year_end = $("#year_end").val();
                var month_end = $("#month_end").val();
                $.get('action/action_stat_show.php?year_start=' + year_start + '&month_start=' + month_start + '&year_end=' + year_end + '&month_end=' + month_end + '&get_year_start=' + get_year_start + '&get_month_start=' + get_month_start + '&get_year_end=' + get_year_end + '&get_month_end=' + get_month_end, function (data, status) {
                    $("#show_stat_table").html(data);
                });
            }


            function go_to_chart() {
                var year_start = $("#year_start").val();
                var month_start = $("#month_start").val();
                var year_end = $("#year_end").val();
                var month_end = $("#month_end").val();
                var x = location.href = 'chart.php?year_start=' + year_start + '&month_start=' + month_start + '&year_end=' + year_end + '&month_end=' + month_end ;
            }

        </script>
        <script>
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