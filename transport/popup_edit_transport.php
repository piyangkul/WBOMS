<!--  CONNECT DATABASE  -->
<?php
require_once 'function/func_transport.php';
?>

<?php
if (isset($_GET['idtransport'])) {
    $idtransport = $_GET['idtransport'];
    $getTransports = getTransportByID($idtransport);
    $val_idtransport = $getTransports['idtransport'];
    $val_name_transport = $getTransports['name_transport'];
    $val_tel_transport = $getTransports['tel_transport'];
    $val_address_transport = $getTransports['address_transport'];
}
?>
<form class="form" action="action/action_editTransport.php?idtransport=<?php echo $idtransport; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขขนส่ง</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label>รหัสขนส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" name="idtransport" value="<?php echo $val_idtransport; ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>ชื่อขนส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" name="name_transport" value="<?php echo $val_name_transport; ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>เบอร์โทรศัพท์</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                        <input type="text" class="form-control" name="tel_transport" value="<?php echo $val_tel_transport; ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>ที่อยู่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="text" class="form-control" name="address_transport" value="<?php echo $val_address_transport; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <p id="alertPass"></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" class="btn btn-primary">Save changes</button>
    </div>
</form>