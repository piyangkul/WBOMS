<?php
require_once 'function/func_shipment.php';
?>
<?php
$idproduct_order = $_GET['idproduct_order'];
$idshipment_period = $_GET['idshipment_period'];
$idfactory = $_GET['idfactory'];
$getProduct_order = getProduct_orderByID($idproduct_order);

$val_amount_product_order = $getProduct_order['amount_product_order'];
$val_name_unit = $getProduct_order['name_unit'];

$val_idunit = $getProduct_order['idunit'];
$val_idproduct = $getProduct_order['idproduct'];
$val_idunitOld = $getProduct_order['idunit'];
$price = $_GET['price'];
$status_shipment_factorys = $_GET['status_shipment'];

$getCode = getUnit3($val_idunit);
$code = $getCode['code_product'];

$val_name_product = '[' . $code . "] " . $getProduct_order['name_product'] . " - " . $getCode['name_factory'];

/* echo $val_idproduct . " ";
  echo $val_idunitOld . " ";
  echo $val_amount_product_order; */
?>

<script>
    function LoadData(str) {
        var idunitOld = <?= $val_idunitOld; ?>;
        //alert(idunitOld);
        var idproduct = document.getElementById('idP').value;
        //alert(idproduct);
        var amount = <?= $val_amount_product_order; ?>;
        //alert(amount);
        $.ajax({type: "GET",
            url: "action/action_session_amount.php",
            async: false,
            data: "idunitNew=" + str + "&idunitOld=" + idunitOld + "&idproduct=" + idproduct + "&amount=" + amount,
            dataType: 'html',
            success: function (response)
            {
                $("#amount_total").val(response);
            }
        });

    }

</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">แก้ไขจำนวนสินค้า</h4>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
            </div>
            <div class="form-group col-xs-12">
                <label for="name_product">ชื่อสินค้า</label><label class="text-danger">*</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                    <input type="text" class="form-control" id="name_product" name="name_product" value="<?php echo $val_name_product; ?>" disabled>
                    <input type="hidden" id="idP" name="idP" value="<?= $val_idproduct; ?>"/>
                </div>
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;">
                <label for="amount_product_order">จำนวน</label><label class="text-danger">*</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-circle-o-notch"></i></span>
                    <input type="text" class="form-control" id="amount_product_order" name="amount_product_order" value="<?php echo $val_amount_product_order; ?>">
                    <input type="hidden" class="form-control" id="amount_old" name="amount__old" value="<?php echo $val_amount_product_order; ?>">
                </div>
            </div>
            <div class="form-group col-xs-12" style="float:left;width:50%;">
                <label for="name_unit">หน่วยสินค้า</label><label class="text-danger">*</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                    <select class="form-control" id="name_unit" name="name_unit" onchange="LoadData(this.value)" required >
                        <option selected value="<?= $val_idunit; ?>"><?= $val_name_unit; ?></option>
                        <?php
                        $getUnit = getUnit($val_idproduct, $val_idunit);
                        foreach ($getUnit as $value) {
                            $val_idunit = $value['idunit'];
                            $val_name_unit = $value['name_unit'];
                            ?>
                            <option value="<?= $val_idunit; ?>"><?= $val_name_unit; ?></option><?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input id="amount_total" name="amount_total" class="hidden" value="<?= $val_amount_product_order; ?>"/>
            <input id="idUnitOld" name="idUnitOld" class="hidden" value="<?= $val_idunitOld; ?>"/>
            <input id="status_shipment_factory" name="status_shipment_factory" class="hidden" value="<?= $status_shipment_factorys; ?>"/>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" onclick="editProduct()" class="btn btn-primary">Save changes</button>
</div>

<script>
    function editProduct() {

        if (document.getElementById("amount_product_order").value.length > 0) {
            var idUnit = parseInt($("#name_unit").val());
            var idUnitOld = parseInt($("#idUnitOld").val());
            var idshipment_period = <?= $idshipment_period; ?>;
            var idproduct_order = <?= $idproduct_order; ?>;
            var idfactory = <?= $idfactory; ?>;
            var price = <?= $price; ?>;
            var status_shipment = $("#status_shipment_factory").val();
            var amount_product_order = $("#amount_product_order").val();

            var amountOld = document.getElementById("amount_total").value;
            amount_product_order = parseFloat(amount_product_order);
            amountOld = parseFloat(amountOld);
            if (idUnitOld === idUnit) {
                amount_product_order = parseFloat(amount_product_order);
                amountOld = parseFloat(amountOld);
                if (amount_product_order < amountOld) {

                    var confirms = confirm("คุณต้องการเพิ่มสินค้าที่ยังคงค้างไปในรอบถัดไปหรือไม่");
                    if (confirms === true) {
                        var addP = "addP";
                        var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment + "&addP=" + addP;
                        //alert(p);
                        $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                            //alert("Data: " + data + "\nStatus: " + status);
                            if (data == "1") {
                                $("#alert").html("บันทึกแล้ว");
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                            else {
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                        }
                        );
                        $('#myModal').modal('hide');
                        window.location.href = '../interface_add_order/add_order.php?ship=ship';
                    } else {
                        var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment;
                        //alert(p);
                        $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                            //alert("Data: " + data + "\nStatus: " + status);
                            if (data == "1") {
                                $("#alert").html("บันทึกแล้ว");
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                            else {
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                        }
                        );
                        window.location.href = "add_shipment3.php?idshipment_period=" + idshipment_period + "&idfactory=" + idfactory + "&price=" + price + "&status_shipment=" + status_shipment + "&action=editProduct_orderCompleted";
                    }
                }
                else {
                    var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment;
                    //alert(p);
                    $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                        //alert("Data: " + data + "\nStatus: " + status);
                        if (data == "1") {
                            $("#alert").html("บันทึกแล้ว");
                            $("#name_unit").val("");
                            $("#idUnitOld").val("");
                            $("#status_shipment_factory").val("");
                            $("#amount_product_order").val("");
                            $("#amount_old").val("");
                        }
                        else {
                            $("#name_unit").val("");
                            $("#idUnitOld").val("");
                            $("#status_shipment_factory").val("");
                            $("#amount_product_order").val("");
                            $("#amount_old").val("");
                        }
                    }
                    );
                    window.location.href = "add_shipment3.php?idshipment_period=" + idshipment_period + "&idfactory=" + idfactory + "&price=" + price + "&status_shipment=" + status_shipment + "&action=editProduct_orderCompleted";
                }
            } else if (idUnitOld < idUnit) {
                amount_product_order = parseFloat(amount_product_order);
                amountOld = parseFloat(amountOld);
                //alert("789");
                if (amount_product_order < amountOld) {
                    //alert(amount_product_order + "<" + amountOld);
                    var confirms = confirm("คุณต้องการเพิ่มสินค้าที่ยังคงค้างไปในรอบถัดไปหรือไม่");
                    if (confirms === true) {
                        var addP = "addP";
                        var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment + "&addP=" + addP;
                        //alert(p);
                        $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                            //alert("Data: " + data + "\nStatus: " + status);
                            if (data == "1") {
                                $("#alert").html("บันทึกแล้ว");
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                            else {
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                        }
                        );
                        $('#myModal').modal('hide');
                        window.location.href = '../interface_add_order/add_order.php?ship=ship';
                    } else {
                        var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment;
                        //alert(p);
                        $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                            // alert("Data: " + data + "\nStatus: " + status);
                            if (data == "1") {
                                $("#alert").html("บันทึกแล้ว");
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                            else {
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                        }
                        );
                        window.location.href = "add_shipment3.php?idshipment_period=" + idshipment_period + "&idfactory=" + idfactory + "&price=" + price + "&status_shipment=" + status_shipment + "&action=editProduct_orderCompleted";

                    }
                } else if (amount_product_order >= amountOld) {
                    amount_product_order = parseFloat(amount_product_order);
                    amountOld = parseFloat(amountOld);
                    var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment;
                    //alert(p);
                    $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                        //alert("Data: " + data + "\nStatus: " + status);
                        if (data == "1") {
                            $("#alert").html("บันทึกแล้ว");
                            $("#name_unit").val("");
                            $("#idUnitOld").val("");
                            $("#status_shipment_factory").val("");
                            $("#amount_product_order").val("");
                            $("#amount_old").val("");
                        }
                        else {
                            $("#name_unit").val("");
                            $("#idUnitOld").val("");
                            $("#status_shipment_factory").val("");
                            $("#amount_product_order").val("");
                            $("#amount_old").val("");
                        }
                    }
                    );
                    window.location.href = "add_shipment3.php?idshipment_period=" + idshipment_period + "&idfactory=" + idfactory + "&price=" + price + "&status_shipment=" + status_shipment + "&action=editProduct_orderCompleted";

                }
            } else if (idUnitOld > idUnit) {
                amount_product_order = parseFloat(amount_product_order);
                amountOld = parseFloat(amountOld);
                //alert("555");
                if (amount_product_order < amountOld) {
                    var confirms = confirm("คุณต้องการเพิ่มสินค้าที่ยังคงค้างไปในรอบถัดไปหรือไม่");
                    if (confirms === true) {
                        var addP = "addP";
                        var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment + "&addP=" + addP;
                        //alert(p);
                        $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                            //alert("Data: " + data + "\nStatus: " + status);
                            if (data == "1") {
                                $("#alert").html("บันทึกแล้ว");
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                            else {
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                        }
                        );
                        $('#myModal').modal('hide');
                        window.location.href = '../interface_add_order/add_order.php?ship=ship';
                    }
                    else {
                        var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment;
                        //alert(p);
                        $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                            //alert("Data: " + data + "\nStatus: " + status);
                            if (data == "1") {
                                $("#alert").html("บันทึกแล้ว");
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                            else {
                                $("#name_unit").val("");
                                $("#idUnitOld").val("");
                                $("#status_shipment_factory").val("");
                                $("#amount_product_order").val("");
                                $("#amount_old").val("");
                            }
                        }
                        );
                        window.location.href = "add_shipment3.php?idshipment_period=" + idshipment_period + "&idfactory=" + idfactory + "&price=" + price + "&status_shipment=" + status_shipment + "&action=editProduct_orderCompleted";

                    }
                } else {
                    var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment;
                    //alert(p);
                    $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                        //alert("Data: " + data + "\nStatus: " + status);
                        if (data == "1") {
                            $("#alert").html("บันทึกแล้ว");
                            $("#name_unit").val("");
                            $("#idUnitOld").val("");
                            $("#status_shipment_factory").val("");
                            $("#amount_product_order").val("");
                            $("#amount_old").val("");
                        }
                        else {
                            $("#name_unit").val("");
                            $("#idUnitOld").val("");
                            $("#status_shipment_factory").val("");
                            $("#amount_product_order").val("");
                            $("#amount_old").val("");
                        }
                    }
                    );
                    window.location.href = "add_shipment3.php?idshipment_period=" + idshipment_period + "&idfactory=" + idfactory + "&price=" + price + "&status_shipment=" + status_shipment + "&action=editProduct_orderCompleted";

                }
            } else {
                var p = "&name_unit=" + idUnit + "&idshipment_period=" + idshipment_period + "&idproduct_order=" + idproduct_order + "&idfactory=" + idfactory + "&amount_product_order=" + amount_product_order + "&price=" + price + "&status_shipment=" + status_shipment;
                //alert(p);
                $.get("action/action_edit_amount_product_order.php?p=editProduct" + p, function (data, status) {
                    //alert("Data: " + data + "\nStatus: " + status);
                    if (data == "1") {
                        $("#alert").html("บันทึกแล้ว");
                        $("#name_unit").val("");
                        $("#idUnitOld").val("");
                        $("#status_shipment_factory").val("");
                        $("#amount_product_order").val("");
                        $("#amount_old").val("");
                    }
                    else {
                        $("#name_unit").val("");
                        $("#idUnitOld").val("");
                        $("#status_shipment_factory").val("");
                        $("#amount_product_order").val("");
                        $("#amount_old").val("");
                    }
                }
                );
                window.location.href = "add_shipment3.php?idshipment_period=" + idshipment_period + "&idfactory=" + idfactory + "&price=" + price + "&status_shipment=" + status_shipment + "&action=editProduct_orderCompleted";
            }
        }
        else {
            alert("กรุณากรอกข้อมูลให้ครบ");
        }
    }



</script>