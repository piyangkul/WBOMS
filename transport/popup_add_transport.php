<form class="form" action="transport.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มขนส่ง</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="idtransport">รหัสขนส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกรหัสขนส่ง" name ="idtransport" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport">ชื่อขนส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกชื่อขนส่ง" name="name_transport" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="tel_transport">เบอร์โทรศัพท์</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกเบอร์โทรศัพท์" name="tel_transport" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="address_transport">ที่อยู่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกที่อยู่" name="address_transport" required=""/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <p id="alertPass"></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" value="addTransport" class="btn btn-primary">Save changes</button>
    </div>
</form>



