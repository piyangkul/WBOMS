<form class="form" action="action/action_addMember.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มสมาชิก</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name">ชื่อ</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกชื่อ" name ="name_member" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="lastname">นามสกุล</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอกนามสกุล" name="lastname_member" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="username">Username</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"  ></i></span>
                        <input type="text" class="form-control" placeholder="กรุณากรอก Username " name = "username" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="password">Password</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="password" onchange="chkPassMatch()" class="form-control" placeholder="Password" name ="password" id = "password" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="password">Confirm Password</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                        <input type="password" onchange="chkPassMatch()" class="form-control" placeholder="Confirm Password" name ="confirm_password" id = "confirm_password" required=""/>
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
