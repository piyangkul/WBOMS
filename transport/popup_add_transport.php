<form class="form" action="action/action_addTransport.php" method="post">
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
                        <input type="text" class="form-control" name="idtransport" placeholder="กรุณากรอกรหัสขนส่ง" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport">ชื่อขนส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" name="name_transport" placeholder="กรุณากรอกชื่อขนส่ง" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="tel_transport">เบอร์โทรศัพท์</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                        <input type="text" class="form-control" name="tel_transport" placeholder="กรุณากรอกเบอร์โทรศัพท์" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="address_transport">ที่อยู่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="text" class="form-control" name="address_transport" placeholder="กรุณากรอกที่อยู่" required=""/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit_transport" class="btn btn-primary">Save changes</button>
    </div>
</form>



