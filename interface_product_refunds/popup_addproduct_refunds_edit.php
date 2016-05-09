<?php require_once 'function/func_addorder.php'; ?>
<?php
session_start();
$idproduct_refunds = $_GET['idproduct_refunds'];
$idunit = $_GET['idunit'];
$amount = $_GET['amount'];
$price = $_GET['price'];
$total = $_GET['total_price'];
$diff = $_GET['diff'];
$price_factory = $_GET['price_factory'];
$getUnit = getUnit3($idunit);
$idProduct = $getUnit['idproduct'];


$amount_plus = 1;
$getDiff = getDiffBathaction($idProduct, $idunit);
foreach ($getDiff as $value) {
    $val_amount_unit = $value['amount_unit'];
    $val_price = $value['price_unit'];
    $amount_plus = $val_amount_unit * $amount_plus;
}

$nameUnit = $getUnit['name_unit'];
$nameFactory = $getUnit['name_factory'];
$nameProduct = "[" . $getUnit['code_product'] . "] " . $getUnit['name_product'] . " - " . $nameFactory;
$idFactory = $getUnit['idfactory'];
$type_factory = $getUnit['type_factory'];
?>
<script>
    var Product = JSON.stringify(<?php echo getProduct4(); ?>);
    var ProductP = JSON.parse(Product);
    var productName = new Array();
    var productId = new Array();
    var factoryName = new Array();
    var factoryId = new Array();
    var factoryDiff = new Array();
    for (var i = 0; i < ProductP.length; i++) {
        productName.push(ProductP[i].name_product);
        productId["'" + ProductP[i].name_product + "'"] = ProductP[i].idproduct;
        factoryName["'" + ProductP[i].name_product + "'"] = ProductP[i].name_factory;
        factoryId["'" + ProductP[i].name_product + "'"] = ProductP[i].idfactory;
        factoryDiff["'" + ProductP[i].name_product + "'"] = ProductP[i].difference_amount_factory;
    }
    $(function () {
        $("#name_product").autocomplete({
            source: productName
        });
    });
    function getProductID() {
        var name_shop = document.getElementById("name_product").value;
        document.getElementById("name_factory").value = factoryName["'" + name_shop + "'"];
        document.getElementById("idproduct").value = productId["'" + name_shop + "'"];
        document.getElementById("idfactory").value = factoryId["'" + name_shop + "'"];
        //document.getElementById("difference").value = factoryDiff["'" + name_shop + "'"];
        var id = productId["'" + name_shop + "'"];
        $.ajax({type: "GET",
            url: "action/action_ajax_product.php",
            async: false,
            data: "q=" + id,
            dataType: 'html',
            success: function (response)
            {
                $("#idUnit").html(response);
                //alert(response);
            }
        });
        var iddiff = productId["'" + name_shop + "'"];
        var idshop = document.getElementById('idshop').value;
        $.ajax({type: "GET",
            url: "action/action_ajax_hisdiff.php",
            async: false,
            data: "q=" + iddiff + "&idshop=" + idshop,
            dataType: 'html',
            success: function (www)
            {
                $("#diff").val(www);
                //alert(response);
            }
        });
    }
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">แก้ไขสินค้า</h4>

</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
            </div>
            <div class="form-group col-xs-12">
                <label>ชื่อสินค้า</label>
                <div class="input-group ui-front">
                    <span class="input-group-addon"><i class="fa fa-cube" ></i></span>
                    <input type="text" class="form-control" id="name_product" name="name_product" placeholder="กรุณาระบุชื่อสินค้า" onblur="getProductID()" autocomplete= "on" value="<?= $nameProduct; ?>" disabled></input>
                    <input type="hidden" id="idproduct" name="idproduct" value="<?= $idProduct; ?>">
                    <input type="hidden" class="form-control" id="name_factory" name="name_factory" placeholder="กรุณาระบุชื่อสินค้า" value="<?= $nameFactory; ?>" disabled>
                    <input type="hidden" id="idfactory" name="idfactory" value="<?= $idFactory ?>">
                    <input type="hidden" class="form-control" id="typefactory" name="typefactory" value="<?= $type_factory; ?>">
                    <input type="hidden" class="form-control" id="idshop" name="idshop" value="<?= $_SESSION['idshopP']; ?>">
                    <input type="hidden" id="idFactory2">
                </div>
            </div>

            <div class="form-group col-xs-12" style="float:left;width:50%;">
                <label for="amount_product">จำนวน</label>
                <input type="text" class="form-control" id="AmountProduct" placeholder="กรอกจำนวนสินค้า" value ="<?= $amount; ?>" onkeyup="updateAmount()" required="true">
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;"> 
                <label> หน่วย</label>  <font size="1" color ="red">*กรุณาเลือกสินค้าก่อน</font>
                <select class="form-control" id="idUnit" name="idUnit" onchange="LoadData(this.value)" required>
                    <option value="<?= $idunit ?>"><?= $nameUnit; ?></option>
                    <?php
                    $getUnit = edit_unit($idProduct, $idunit);
                    foreach ($getUnit as $value) {
                        $val_idunit = $value['idunit'];
                        $val_name_unit = $value['name_unit'];
                        ?>
                        <option value="<?= $val_idunit; ?>"><?= $val_name_unit; ?></option><?php
                    }
                    ?>     
                </select>
                <div id="tee"></div>
            </div>

            <div class="form-group col-xs-12">
                <label>ส่วนลดสินค้าคืน</label>
                <input type="text" class="form-control" id="diff" onkeyup="updateAmount()" value="<?= $diff ?>">
            </div>


            <div class="form-group col-xs-12">
                <label>ราคาคืนต่อหน่วย</label>
                <input type="hidden" id="diffBath" name="diffBath" value="<?= $amount_plus; ?>">
                <input type="hidden" class="form-control" id="price_factory" readonly="true" value="<?= number_format($price_factory, 2); ?>">
                <input type="hidden" class="form-control" id="diff" readonly="true" value="<?= $diff ?>">

                <input type="text" class="form-control" id="price" readonly="true" value="<?= number_format($price, 2); ?>" onkeyup="updateAmount()">
            </div>
            <div class="form-group col-xs-12">
                <label>ราคาคืนทั้งหมด</label>
                <input type="text" class="form-control" id="total_price" readonly="true" onkeyup="updateAmount()" value ="<?= number_format($total, 2); ?>">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ประวัติคำสั่งสินค้า
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th class="text-center">วันที่สั่งซื้อ</th>
                                            <th class="text-center">จำนวนสินค้า</th>
                                            <th class="text-center">ราคาต่อหน่วย</th>
                                            <th class="text-center">ต้นทุนลด%</th>
                                            <th class="text-center">ส่วนลด</th>
                                            <th class="text-center">ราคาขาย</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_product_order">
                                        <?php
                                        $idshop = $_SESSION['idshopP'];
                                        $getTable = getTableProduct($idProduct, $idshop);

                                        $i = 1;
                                        foreach ($getTable as $value) {
                                            $val_date = $value['date_order_p'];
                                            $val_name_unit = $value['name_unit'];
                                            $val_amount_unit = $value['amount_product_order'];
                                            $val_price_unit = $value['price_unit'];
                                            $val_type_product_order = $value['type_product_order'];
                                            $val_difference_amount = $value['difference_amount_product'];
                                            $val_difference_product_order = $value['difference_product_order'];
                                            $total_price_per = ($val_price_unit - (($val_price_unit * $val_difference_product_order) / 100)) * $val_amount_unit;
                                            $total_price_bath = ($val_price_unit - $val_difference_product_order) * $val_amount_unit;
                                            echo "<tr><td class ='text-center'>{$i}</td>";
                                            echo "<td class ='text-center'>{$val_date}</td>";
                                            echo "<td class ='text-center'>{$val_amount_unit} {$val_name_unit}</td>";
                                            echo "<td class ='text-center'>{$val_price_unit}</td>";
                                            if ($val_type_product_order === "PERCENT") {
                                                echo "<td class ='text-center'>{$val_difference_amount}</td>";
                                                echo "<td class ='text-center'>{$val_difference_product_order} %</td>";
                                                echo "<td class ='text-center'>{$total_price_per} </td></tr>";
                                            } else {
                                                echo "<td class ='text-center'>-</td>";
                                                echo "<td class ='text-center'>{$val_difference_product_order}฿</td>";
                                                echo "<td class ='text-center'>{$total_price_bath} </td></tr>";
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <p id="alertPass"></p>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" onclick="editProduct();">Save changes</button>
</div>
<script>

    function editProduct() {
        if (document.getElementById("name_product").value.length > 0 && document.getElementById("AmountProduct").value.length > 0) {
            var idUnit = $("#idUnit").val();
            var productName = $("#idproduct").val();
            var factoryName = $("#idfactory").val();
            var AmountProduct = $("#AmountProduct").val();
            var price = $("#price").val().replace(',', '');
            var total_price = $("#total_price").val().replace(',', '');
            var diff = $("#diff").val()
            var price_factory = $("#price_factory").val().replace(',', '');
            var type_factoty = $("#typefactory").val();
            var idproduct_refunds = <?= $idproduct_refunds ?>;
            //alert(idUnit);
            //alert(AmountProduct);
            //alert(DifferencePer);
            //alert(DifferenceBath);
            var p = "&idproduct_refunds=" + idproduct_refunds + "&idUnit=" + idUnit + "&productName=" + productName + "&factoryName=" + factoryName + "&AmountProduct=" + AmountProduct + "&price=" + price + "&total_price=" + total_price + "&typefactory=" + type_factoty + "&price_factory=" + price_factory + "&diff=" + diff;
            //alert(p);
            $.get("action_addProduct.php?p=editProduct" + p, function (data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                if (data == "1") {
                    $("#alert").html("บันทึกแล้ว");
                    $("#idUnit").val("");
                    $("#productName").val("");
                    $("#factoryName").val("");
                    $("#AmountProduct").val("");
                    $("#price").val("");
                    $("#total_price").val("");
                    showUnit();
                }
                else {
                    $("#idUnit").val("");
                    $("#productName").val("");
                    $("#factoryName").val("");
                    $("#AmountProduct").val("");
                    $("#price").val("");
                    $("#total_price").val("");
                    showUnit();

                }
            });
            $('#myModal-lg').modal('hide');
        } else {
            alert("กรุณากรอกข้อมูลให้ครบ");
        }
    }

</script>
