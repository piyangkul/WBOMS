<form class="form" action="action/action_addShipment.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่ม/อัพเดท ข้อมูลการส่งสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label>วันที่ส่งสินค้า<label class="text-danger">*</label></label>
                    <input type="date" class="form-control" id="date_end" name="date_end" required />
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport">ชื่อบริษัทขนส่ง</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-truck"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกชื่อบริษัทขนส่ง" name="name_transport" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="volume">เล่มที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเล่มที่ " name = "volume" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="number">เลขที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเลขที่" name ="number" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <input type="checkbox" onchange="chkPrice_transport()" id="check_price" value="" />
                    <label for="price_transport">ค่าส่งสินค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar"  ></i></span>
                        <input type="text" onchange="chkPrice_transport()" class="form-control" id="price_transport" placeholder="กรุณากรอกค่าส่งสินค้า" name ="price_transport" disabled/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <p id="alertPass"></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="sumbit" class="btn btn-primary">Save changes</button>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#check_price").change(function () {
            if ($("#check_price").val() !== $("#check_price").val()) {
                $("#price_transport").prop('disabled', false);

            }
        });
    });

    function chkPrice_transport() {
        var check_price = $("#check_price").val();
        var price_transport = $("#price_transport").val();
        if (check_price !== check_price) {
            $("#price_transport").prop('disabled', false);
        }
        else {
            $("#price_transport").prop('disabled', true);
        }
    }
</script>