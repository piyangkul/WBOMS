<?php
require_once 'function/func_product.php';
$val_idproduct = $_GET['idproduct']; //ส่งค่าpara
$getProductDetail = getProductDetail($val_idproduct);
$getProductUnit = getProductUnit($val_idproduct);
//echo "<pre>";
//print_r($getProductDetail);
//echo "</pre>";
$val_code_product = $getProductDetail['code_product'];
$val_name_product = $getProductDetail['name_product'];
$val_name_factory = $getProductDetail['name_factory'];
$val_difference_amount_product = $getProductDetail['difference_amount_product'];
?>
<div class = "modal-header">
    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"><span aria-hidden = "true">&times;
        </span></button>
    <h4 class = "modal-title" id = "myModalLabel">รายละเอียดสินค้า</h4>
</div>

<div class = "row">
    <div class = "col-md-10 col-sm-10 ">
        <div class = "form-group col-xs-12">
            <div class = "col-md-12 col-sm-12 ">
            </div>
            <div class = "form-group col-xs-12">
                <label for = "disabledInput1">รหัสสินค้า</label>
                <input type = "text" class = "form-control" id = "disabledInput1" value="<?php echo $val_code_product; ?>" disabled>
            </div>
            <div class = "form-group col-xs-12">
                <label for = "disabledInput2"> ชื่อสินค้า </label>
                <input type = "text" class = "form-control" id = "disabledInput2" value="<?php echo $val_name_product; ?>" disabled>
            </div>
            <div class = "form-group col-xs-12">
                <label for = "disabledInput3"> ชื่อโรงงาน </label>
                <input type = "text" class = "form-control" id = "disabledInput3" value="<?php echo $val_name_factory; ?>" disabled>
            </div>
            <!--หน่วยสินค้า -->
            <div class = "row">
                <div class = "col-md-2 col-sm-2 "></div>
                <div class = "col-md-12 col-sm-12 ">
                    <div class = "panel panel-primary">
                        <div class = "panel-heading">
                            <label>หน่วยสินค้า</label>
                        </div>
                        <div class = "panel-body">
                            <div class = "table-responsive">
                                <br>
                                <table class = "table table-striped table-bordered table-hover text-center"
                                       id = "dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>จำนวนต่อหน่วยใหญ่</th>
                                            <th>หน่วยใหญ่</th>
                                            <th>จำนวนต่อหน่วยรอง</th>
                                            <th>หน่วยรอง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($getProductUnit as $value) {
                                            if ($value['name_big'] == NULL) {
                                                continue;
                                            }
                                            $valUnit = $value['name'];
                                            $valAmount = $value['amount_unit'];
                                            $valBigUnit = $value['name_big'];
                                            ?>
                                            <tr>
                                                <td>1</td>
                                                <td><?php echo $valUnit; ?></td>
                                                <td><?php echo $valAmount; ?></td>
                                                <td><?php echo $valBigUnit; ?></td>
                                            </tr>
                                        <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End หน่วยสินค้า -->

            <!--ราคาสินค้า -->
            <div class = "row">
                <div class = "col-md-2 col-sm-2 "></div>
                <div class = "col-md-12 col-sm-12 ">
                    <div class = "panel panel-primary">
                        <div class = "panel-heading">
                            <label>ราคาสินค้า</label>
                        </div>
                        <div class = "panel-body">
                            <div class = "table-responsive ">
                                <center>
                                    <h4>ต้นทุนลด <?php echo $val_difference_amount_product; ?> %</h4>
                                </center>
                                <table class = "table table-striped table-bordered table-hover text-center"
                                       id = "dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>จำนวนต่อหน่วยใหญ่</th>
                                            <th>หน่วยใหญ่</th>
                                            <th>ราคาเปิด</th>
                                            <th>ราคาต้นทุน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($getProductUnit as $value) {
                                            $valUnit = $value['name'];
                                            $valPrice = $value['price_unit'];
                                            ?>
                                            <tr>
                                                <td>1</td>
                                                <td><?php echo $valUnit; ?></td>
                                                <td><?php echo $valPrice; ?></td>
                                                <td><?php echo $valPrice * ((100 - $val_difference_amount_product) / 100.0); ?></td>
                                            </tr>
                                        <?php } ?>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End ราคาสินค้า -->
        </div>
    </div>
</div>
<div class = "modal-footer">
    <button type = "button" class = "btn btn-default" data-dismiss = "modal">Close</button>
</div>
