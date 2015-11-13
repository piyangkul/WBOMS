<!--  CONNECT DATABASE  -->
<?php
require '../model/db_user.inc.php';
?>

<?php
if (isset($_GET['idmember'])) {
    $idmember = $_GET['idmember'];

    $result = get_member_id($idmember);
    $row = $result->fetch(PDO::FETCH_ASSOC);
}
?>
<form class="form" action="membership.php?id=<?php echo $row["idmember"]; ?>" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขสมาชิก</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label>ชื่อ</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" id="Name" name="name_member" value="<?php echo $row["name"]; ?>"  />
                    </div>
                </div>

                <div class="form-group col-xs-12">
                    <label>นามสกุล</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" id="sName" name="lastname_member" value="<?php echo $row["lastname"]; ?>"  />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>Username</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                        <input type="text" class="form-control" id="userName" name="username" value="<?php echo $row["username"]; ?>" disabled=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>Password</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="password" onchange="chkPassMatch()" class="form-control" name ="password" id = "password" value="<?php echo $row['password'] ?>" />
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label>Confirm Password</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="password" onchange="chkPassMatch()" class="form-control" name ="confirm_password" id = "confirm_password" value="<?php echo $row['password'] ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <p id="alertPass"></p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" value="updateMem" class="btn btn-primary">Save changes</button>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#confirm_password").change(function () {
            if ($("#confirm_password").val() === $("#password").val()) {
                $("#submit").prop('disabled', false);

            }
        });
    });

    function chkPassMatch() {
        var pass1 = $("#password").val();
        var pass2 = $("#confirm_password").val();
        if (pass1 == pass2) {
            $("#submit").prop('disabled', false);
            $("#alertPass").html("");
        }
        else {
            $("#submit").prop('disabled', true);
            $("#alertPass").html("Password is not match!!!");
        }
    }
</script>