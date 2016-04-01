<?php
session_start();
if (!isset($_SESSION['member']))
    header('Location: ../index.php');

$p = 'history_order';
if (isset($_GET['p']) && !empty($_GET['p'])) {
    $p = $_GET['p'];
}
require_once '/function/func_addorder.php';
$val_idorder = $_GET['idorder']; //ส่งค่าpara
$getOrderEdit = getOrderEdit($val_idorder);
$getProductOrder = getProductOrder($val_idorder);
//echo "<pre>";
//print_r($getProductDetail);
//echo "</pre>";
$val_code_order_p = $getOrderEdit['code_order_p'];
$val_date_order_p = $getOrderEdit['date_order_p'];
$val_time_order_p = $getOrderEdit['time_order_p'];
$val_name_shop = $getOrderEdit['name_shop'];
$val_detail_order_p = $getOrderEdit['detail_order_p'];
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


            /*  $(function () {
             var data = JSON.stringify(<?php //getShop2();              ?>);
             //var www = JSON.parse(data);
             //alert(www);
             alert(data);
             $("#code_order").autocomplete({
             source: data
             });
             });
             */
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
                    <form action="action/action_editOrder.php?idorder=<?php echo $val_idorder; ?>" method="post"> 
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
                                                    <input type="text" class="form-control" id="code_order" name="code_order" placeholder="ID บิล" value="<?= $val_code_order_p ?>"disabled>                    
                                                </div>
                                                <p id="www"></p>
                                                <div >
                                                    <p>วันที่สั่งซื้อ <input type="date" class="form-control" id ="date_order" name="date_order"disabled></p>
                                                    <input type="time" class="form-control" id ="time_order" name="time_order" value="<?= $val_time_order_p ?>" disabled>
                                                </div>
                                                <div>
                                                    <label for="disabled_shop">ชื่อร้านค้า</label>
                                                    <input type="text" class="form-control" id="name_order" name="name_shop" placeholder="ชื่อร้านค้า" value="<?= $val_name_shop ?>" disabled>
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

                                                <a href="popup_edit_addproduct_order.php" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
                                                    <span class="glyphicon glyphicon-plus"></span> เพิ่มสินค้า </a>
                                                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                                    <thead>
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ชื่อโรงงาน</th>
                                                            <th>หน่วย</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคาเปิด</th>
                                                            <th>ต้นทุนลด%</th>
                                                            <th>ขายลด%</th>
                                                            <th>ขายเพิ่มสุทธิ</th>
                                                            <th>ราคาขาย</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($getProductOrder as $value) {
                                                            $i++;
                                                            $val_name_product = $value['name_product'];
                                                            $val_name_unit = $value['name_unit'];
                                                            $val_name_factory = $value['name_factory'];
                                                            $val_amount_product_order = $value['amount_product_order'];
                                                            $val_difference_product_order = $value['difference_product_order'];
                                                            $val_type_product_order = $value['type_product_order'];
                                                            $val_difference_amount_factory = $value['difference_amount_factory'];
                                                            $val_price_unit = $value['price_unit'];
                                                            $total_open = $val_price_unit * $val_amount_product_order;
                                                            $total_percent = $total_open - ($total_open * ($val_difference_product_order / 100));
                                                            $total_bath = $total_open - ($val_difference_product_order * $val_amount_product_order);
                                                            ?>
                                                            <tr>
                                                                <td><?= $i; ?></td>
                                                                <td><?= $val_name_product; ?></td>
                                                                <td><?= $val_name_factory; ?></td>
                                                                <td><?= $val_name_unit; ?></td> 
                                                                <td><?= $val_amount_product_order; ?></td>
                                                                <td><?= $total_open; ?> </td>
                                                                <td><?= $val_difference_amount_factory; ?></td>
                                                                <?php if ($val_type_product_order === 'PERCENT') { ?>
                                                                    <td><?= $val_difference_product_order; ?></td>
                                                                    <td>-</td>
                                                                    <td><?= $total_percent; ?></td>
                                                                <?php }
                                                                ?>
                                                                <?php if ($val_type_product_order === 'BATH') {
                                                                    ?>
                                                                    <td>-</td>
                                                                    <td><?= $val_difference_product_order; ?></td>                                                                  
                                                                    <td><?= $total_bath; ?></td>
                                                                <?php }
                                                                ?>    


                                                            </tr>
                                                        <?php } ?>
                                                </table>

                                                <div class="col-md-6"></div>
                                                <div class="col-md-4">
                                                    <label for="disabled_no">ราคาขายรวมต่อบิล</label>
                                                    <input type="text" class="form-control" id="disabled_no" placeholder=" " disabled>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--End  ตารางสินค้าที่สั่งซื้อ --> 
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="form-group col-xs-8">
                                            <label for="exampleInputName2">รายละเอียดเพิ่มเติม</label>
                                            <textarea rows="4" cols="50" id = "detail_order" name ="detail_order" class="form-control" placeholder="กรอกรายละเอียดเพิ่มเติม" value="" disabled><?= $val_detail_order_p?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>                              
                                        
                                        <a href="order.php" class="btn btn-danger btn-lg text-center">
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
        $.get("action_editProduct.php?p=showUnit", function (data, status) {
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
                    // alert(response);
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