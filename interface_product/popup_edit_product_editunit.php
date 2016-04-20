<?php
//session_start();
require_once 'function/func_product.php';
$unitID = $_GET['unitid'];
$getUnit = getProductUnitByID($unitID);
$nameUnit = $getUnit['name'];
$AmountPerUnit = $getUnit['amount_unit'];
$under_unitid = $getUnit['idunit_big'];
$price = $getUnit['price_unit'];
$type = $getUnit['type_unit'];
$idProduct = $getUnit['idproduct'];
$numUnit = $_GET['countUnit'];
$idUnitBig = $_GET['idUnitBig'];

$getBigUnit = getProductUnitBYID($under_unitid);
$priceBig = $getBigUnit['price_unit'];
$getAllUnit = getProductUnit($idProduct);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">แก้ไขหน่วยสินค้า</h4>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
                <!--<p id="alert"></p>-->
            </div>
            <div class="form-group col-xs-12">
                <label for="NameUnit">ชื่อหน่วยสินค้า</label>
                <input type="text" class="form-control" name="NameUnit" id="NameUnit" placeholder="ใส่หน่วยสินค้า เช่น(กล่อง)" value="<?php echo $nameUnit; ?>">
            </div>
            <div class="form-group col-xs-12">
                <label for="AmountPerUnit">จำนวนต่อหน่วยใหญ่</label>
                <input type="text" class="form-control" name="AmountPerUnit" onkeyup="calPrice();" id="AmountPerUnit" placeholder="ใส่จำนวนต่อหน่วยรอง เช่น(2)"  value="<?php echo $AmountPerUnit; ?>">
            </div>
            <div class="form-group col-xs-12">
                <label for="under_unit">หน่วยใหญ่ที่จะเปรียบเทียบ</label>
            </div>
            <div class="form-group col-xs-12">
                <select class="form-control" name="under_unit" id="under_unit" onchange="" disabled>
                    <option selected value="">Choose</option>
                    <?php
                    foreach ($getAllUnit as $value) {
                        $valIdUnit = $value['idunit'];
                        $valNameUnit = $value['name'];
                        ?> 
                        <option <?php echo $valIdUnit == $under_unitid ? "selected" : ""; ?> value="<?php echo $valIdUnit; ?>"><?php echo $valNameUnit; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-xs-12">
                <label for="price">ราคาต่อหน่วยสินค้า</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="0" value="<?php echo $price; ?>" readonly>

            </div>
            <div class="form-group col-xs-12">
                <div class="col-md-12 col-sm-12 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <label>ประเภทหน่วยสินค้า</label>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive ">
                                <label class="radio-inline">
                                    <input <?php echo $type == "PRIMARY" ? "checked" : ""; ?> type="radio" name="type" id="type" value="PRIMARY"> ขาย
                                </label>
                                <label class="radio-inline">
                                    <input <?php echo $type == "SECOND" ? "checked" : ""; ?> type="radio" name="type" id="type" value="SECOND"> ไม่ขาย
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="editUnit();" data-dismiss="modal">Save</button>
    <!--<button type="button" onclick="addUnit();" class="btn btn-primary">Save changes</button>-->
</div>


<script>
    function editUnit() {
        var idUnit = "<?php echo $unitID; ?>";
        var NameUnit = $("#NameUnit").val();
        var AmountPerUnit = $("#AmountPerUnit").val();
        var idUnitBig = "<?php echo $idUnitBig; ?>"
        var numUnit = "<?= $numUnit; ?>"
        // var under_unit = $("#under_unit").val();
        var price = $("#price").val();
        var type = $("input:radio[name=type]:checked").val();
        var idproduct = "<?= $idProduct; ?>";

        var p = "&NameUnit=" + NameUnit + "&AmountPerUnit=" + AmountPerUnit + "&price=" + price + "&type=" + type + "&idUnit=" + idUnit + "&idUnitBig=" + idUnitBig + "&numUnit=" + numUnit;
        //alert(p);
        $.get("action_editUnitE.php?p=editUnit" + p, function (data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            if (data == "1") {
                $("#alert").html("บันทึกแล้ว")
                $("#NameUnit").val("");
                $("#AmountPerUnit").val("");
                $("#under_unit").val("");
            }
            else {
                $("#NameUnit").val("");
                $("#AmountPerUnit").val("");
                $("#under_unit").val("");
            }
        });
        /*document.getElementById("AmountPerUnitSmall<?= $unitID; ?>").innerHTML = AmountPerUnit;
         document.getElementById("nameUnitSmall<?= $unitID; ?>").innerHTML = NameUnit;
         document.getElementById("PriceSmall<?= $unitID; ?>").innerHTML = price;*/
        window.location.href = 'edit_product.php?idproduct=' + idproduct;
    }
    /*chkUnitAdd();
     function chkUnitAdd() { // Check to add the first time 
     $.get("action_addUnit.php?p=chkUnitAdd", function (data, status) {
     //            alert(data);
     if (data == '1') {
     //$("#price").prop("readonly", true);
     $("#under_unit").prop("disabled", false);
     }
     else {
     //$("#price").prop("readonly", false);
     //$("#under_unit").prop("disabled", true);
     $("#AmountPerUnit").val(1);
     $("#AmountPerUnit").prop("readonly", true);
     }
     });
     }*/

    function calPrice() {
        var amount = document.getElementById("AmountPerUnit").value;
        var priceBig = <?= $priceBig; ?>;
        var total = (priceBig * 1) / (amount * 1);
        document.getElementById("price").value = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    }
</script>