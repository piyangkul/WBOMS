<form class="form" action="action/action_addFactory.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มโรงงาน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12"></div>
                <div class="form-group col-xs-12">
                    <label for="code_factory">รหัสโรงงาน</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-circle-o-notch" ></i></span>
                        <input type="text" maxlength="4" class="form-control" name="code_factory" placeholder="กรอกรหัสโรงงาน"  required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_factory">ชื่อโรงงาน</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-building" ></i></span>
                        <input type="text" class="form-control" name="name_factory" placeholder="กรอกชื่อโรงงาน"  required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="tel_factory">เบอร์โทรศัพท์</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"  ></i></span>
                        <input type="text" maxlength="10" class="form-control" name="tel_factory" placeholder="กรอกเบอร์โทรศัพท์" value="" required=""/>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="contact_factory">ผู้ติดต่อ</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="contact_factory" placeholder="กรอกผู้ติดต่อ" value="" required=""/>
                    </div>
                </div>
                
                <div class="from-group col-md-12 col-sm-12 ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <label>ประเภทส่วนลด</label>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div class="form-group col-xs-12" style="float: left;width: 50%;">
                                    <input type="radio" id="per" name="type" onclick="chkPer()" value="PERCENT" checked> เปอร์เซนต์
                                </div>
                                <div class="form-group col-xs-12" style="float: left;width: 50%;">
                                    <input type="radio" id="bath" name="type" onclick="chkBath()" value="BATH"> สุทธิ              
                                </div>
                                <div class="form-group col-xs-12">
                                    <label for="difference_amount_factory">ส่วนลดต้นทุนมาตราฐานของโรงงานเป็น%</label><label class="text-danger">*</label>
                                    <div class="form-group input-group">
                                        <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                        <input type="text" class="form-control" id="difference_amount_factory" name="difference_amount_factory" onblur="chkPer()" placeholder="กรอกต้นทุนลด%" value="" required="" onchange="typefactory()" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="address_factory">ที่อยู่</label><label class="text-danger">*</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-home"></i></span>
                        <textarea rows="4" cols="50" id="address_factory" name="address_factory" class="form-control" placeholder="กรอกที่อยู่โรงงาน"value="" required=""/></textarea>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="detail_factory">รายละเอียดอื่นๆ</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-paperclip"></i></span>
                        <textarea rows="4" cols="50" id="detail_factory" name="detail_factory" class="form-control" placeholder="กรอกรายละเอียดอื่นๆ" value=""/></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit_factory" class="btn btn-primary">Save changes</button>
    </div>
</form>
<script>
    function chkPer()
    {
        var num = document.getElementById("difference_amount_factory").value.length;
        document.getElementById("difference_amount_factory").disabled = false;
    }
    function chkBath() {
        document.getElementById("difference_amount_factory").value = 0;
        document.getElementById("difference_amount_factory").disabled = true;
    }
</script>