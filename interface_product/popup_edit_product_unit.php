<?php
session_start();
$idUnit = $_GET['idUnit'];
$nameUnit = $_SESSION['unit'][$idUnit]['NameUnit'];
$AmountPerUnit = $_SESSION['unit'][$idUnit]['AmountPerUnit'];
$under_unitid = $_SESSION['unit'][$idUnit]['under_unit'];
$price = $_SESSION['unit'][$idUnit]['price'];
$type = $_SESSION['unit'][$idUnit]['type'];
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">เพิ่มหน่วยสินค้า</h4>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
                <!--<p id="alert"></p>-->
            </div>
            <div class="form-group col-xs-12">
                <label for="NameUnit">ชื่อหน่วยสินค้ารอง</label>
                <input type="text" class="form-control" name="NameUnit" id="NameUnit" placeholder="ใส่หน่วยสินค้า เช่น(กล่อง)" value="<?php echo $nameUnit; ?>">
            </div>
            <div class="form-group col-xs-12">
                <label for="AmountPerUnit">จำนวนต่อหน่วยรอง</label>
                <input type="text" class="form-control" name="AmountPerUnit" onchange="calPrice();" id="AmountPerUnit" placeholder="ใส่จำนวนต่อหน่วยรอง เช่น(2)"  value="<?php echo $AmountPerUnit; ?>">
            </div>
            <div class="form-group col-xs-12">
                <label for="under_unit">หน่วยใหญ่ที่จะเปรียบเทียบ</label>
            </div>
            <div class="form-group col-xs-12">
                <select class="form-control" name="under_unit" id="under_unit" onchange="calPrice();">
                    <option selected value="">Choose</option>
                    <?php
                    for ($i = 1; $i <= $_SESSION["countUnit"]; $i++) {
                        ?> 
                        <option <?php echo $i == $under_unitid ? "selected" : ""; ?> value="<?php echo $i; ?>"><?php echo $_SESSION["unit"][$i]["NameUnit"]; ?></option>
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
                                    <input <?php echo $type == "primary" ? "checked" : ""; ?> type="radio" name="type" id="type" value="primary"> ขาย
                                </label>
                                <label class="radio-inline">
                                    <input <?php echo $type == "second" ? "checked" : ""; ?> type="radio" name="type" id="type" value="second"> ไม่ขาย
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
    <button type="button" class="btn btn-default" onclick="alert('Edit unit complete');
            editUnit();
            showUnit();" data-dismiss="modal">Save</button>
    <!--<button type="button" onclick="addUnit();" class="btn btn-primary">Save changes</button>-->
</div>


<script>
    function editUnit() {
        var idUnit = "<?php echo $idUnit; ?>";
        var NameUnit = $("#NameUnit").val();
        var AmountPerUnit = $("#AmountPerUnit").val();
        var under_unit = $("#under_unit").val();
        var price = $("#price").val();
        var type = $("input:radio[name=type]:checked").val();

        var p = "&NameUnit=" + NameUnit + "&AmountPerUnit=" + AmountPerUnit + "&under_unit=" + under_unit + "&price=" + price + "&type=" + type + "&idUnit=" + idUnit;
//        alert(p);
        $.get("action_addUnit.php?p=editUnit" + p, function (data, status) {
            //alert("Data: " + data + "\nStatus: " + status);
            if (data == "1") {
//                $("#alert").html("บันทึกแล้ว")
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
        getBigestUnit();
        getBigestPrice();
    }
    chkUnitAdd();
    function chkUnitAdd() { // Check to add the first time 
        $.get("action_addUnit.php?p=chkUnitAdd", function (data, status) {
//            alert(data);
            if (data == '1') {
                $("#price").prop("readonly", true);
                $("#under_unit").prop("disabled", false);
            }
            else {
                $("#price").prop("readonly", false);
                $("#under_unit").prop("disabled", true);
                $("#AmountPerUnit").val(1);
                $("#AmountPerUnit").prop("readonly", true);
            }
        });
    }

    function calPrice() {
        var subUnitAmount = $("#AmountPerUnit").val();
        var under_unitID = $("#under_unit").val();
        $.get("action_addUnit.php?p=getPriceUnit&id=" + under_unitID, function (data, status) {
            $("#price").val(data / subUnitAmount);
        });
    }
</script>