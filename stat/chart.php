<?php
require_once 'function/func_stat.php';
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
                            <h2> Statistic </h2>   
                            <h5> สถิติการเงิน </h5>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr/>
                    <a class="btn btn-danger btn-lg" onclick="Back()"><span class="fa fa-arrow-circle-left"></span> Back</a>
                    <br/>
                    <!-- ข้อมูลการเงินรายเดือน-ปี -->
                    <table class="highchart" data-graph-container-before="1" data-graph-type="column" style="display:none" data-graph-xaxis-end-on-tick="1" data-graph-height="550" data-graph-subtitle-text="ประกอบด้วย 1.รายได้ 2.รายจ่าย 3.กำไร/ขาดทุน แต่ละรอบ">
                        <caption>กราฟแสดงข้อมูลการเงินรายเดือน-ปี</caption>
                        <thead>
                            <tr>                                  
                                <th>รอบที่</th><!-- เดือน -->                                      
                                <th>รายได้จากร้านค้า</th>
                                <th>รายจ่ายของโรงงาน</th>
                                <th>กำไร/ขาดทุน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //ดึงข้อมูลจากตาราง
                            $getIncome_Outcome = getIncome_Outcome($month_start, $year_start, $month_end, $year_end);
                            foreach ($getIncome_Outcome as $value) {
                                $val_date_start = $value['date_start'];
                                $date_start = date_create($val_date_start);
                                $date_start->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                $val_date_end = $value['date_end'];
                                $date_end = date_create($val_date_end);
                                $date_end->add(new DateInterval('P543Y0M0DT0H0M0S'));
                                $val_income = $value['income'];
                                $val_outcome = $value['outcome'];
                                $profit = $val_income - $val_outcome;
                                ?>
                                <tr>
                                    <td><?php
                            echo date_format($date_start, 'd-m-Y');
                            echo" ถึง ";
                            echo date_format($date_end, 'd-m-Y');
                                ?>
                                    </td>
                                    <td><?php echo $val_income; ?></td>   
                                    <td><?php echo $val_outcome; ?></td>   
                                    <td><?php echo $profit; ?></td> 
                                </tr>

                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
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

        <script>
                        $(document).ready(function () {
                            $('#dataTables-example').dataTable();
                        });
        </script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('table.highchart').highchartTable();
            });

            $(document.body).on('hidden.bs.modal', function () {
                $('#myModal').removeData('bs.modal');
            });
            function Back() {
                window.location.assign("stat.php?year_start=<?php echo $year_start; ?>&month_start=<?php echo $month_start; ?>&year_end=<?php echo $year_end; ?>&month_end=<?php echo $month_end; ?>");
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
