<!--  CONNECT DATABASE  -->
<?php
require '../model/db_user.inc.php';
?>

<?php
if (isset($_GET['idtransport'])) {
    $idmember = $_GET['idtransport'];

    $result = get_transport_id($idtransport);
            $row = $result->fetch(PDO::FETCH_ASSOC);
}
?>
<form class="form" action="transport.php?id=<?php echo $row["idtransport"]; ?>" method="post">
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
                        <input type="text" class="form-control" name="idtransport" value="<?php echo $row["idtransport"]; ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>ชื่อขนส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" name="name_transport" value="<?php echo $row["name_transport"]; ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>เบอร์โทรศัพท์</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                        <input type="text" class="form-control" name="tel_transport" value="<?php echo $row["tel_transport"]; ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>ที่อยู่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="text" class="form-control" name="address_transport" value="<?php echo $row['address_transport'] ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <p id="alertPass"></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" value="updateTransport" class="btn btn-primary">Save changes</button>
    </div>
</form>