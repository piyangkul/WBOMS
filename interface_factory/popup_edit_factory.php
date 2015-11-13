<form class="form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขโรงงาน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName1">ชื่อโรงงาน</label>
                    <input type="text" class="form-control" id="name_factory" placeholder="กรอกชื่อโรงงาน">
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName3">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="Tel" placeholder="กรอกเบอร์โทรศัพท์" >
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName2">ที่อยู่</label>
                    <textarea rows="4" cols="50" name="address" form="usrform" class="form-control" placeholder="กรอกที่อยู่"></textarea>
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName2">ผู้ติดต่อ</label>
                    <input type="text" class="form-control" id="contact" placeholder="กรอกผู้ติดต่อ" >
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName2">อื่นๆ</label>
                    <textarea rows="4" cols="50" name="Other" form="usrform" class="form-control" placeholder="กรอกหมายเหตุอื่นๆ"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
</form>