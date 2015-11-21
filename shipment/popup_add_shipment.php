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
                        <input type="password" class="form-control" placeholder="กรุณากรอกเลขที่" name ="number" />
                    </div>
                </div>
                <div class="form-group col-xs-12 checkbox">
                    <label for="pricetransport">
                        <input type="checkbox" value="">ค่าส่งสินค้า
                    </label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar"  ></i></span>
                        <input type="password" class="form-control" placeholder="กรุณากรอกค่าส่งสินค้า" name ="pricetransport" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <p id="alertPass"></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" value="addMem" class="btn btn-primary">Save changes</button>
    </div>
</form>
