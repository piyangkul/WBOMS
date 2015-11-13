<form class="form" action="factory.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มโรงงาน</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">                
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_factory">ชื่อโรงงาน</label>
                    <input type="text" class="form-control" name="name_factory" placeholder="กรอกชื่อโรงงาน"  required=""/>
                </div>
                <div class="form-group col-xs-12">
                    <label for="tel">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" name="tel_factory" placeholder="กรอกเบอร์โทรศัพท์" value="" required=""/>
                </div>
                <div class="form-group col-xs-12">
                    <label for="address">ที่อยู่</label>
                    <textarea rows="4" cols="50" id="address" name="address_factory" class="form-control" placeholder="กรอกที่อยู่โรงงาน"value="" required=""/></textarea>
                </div>
                <div class="form-group col-xs-12">
                    <label for="contact_factory">ผู้ติดต่อ</label>
                    <input type="text" class="form-control" name="contact_factory" placeholder="กรอกผู้ติดต่อ"/>
                </div>
                <div class="form-group col-xs-12">
                    <label for="difference_amount">ส่วนลดต้นทุนมาตราฐานของโรงงานเป็น%</label>
                    <input type="text" class="form-control" name="difference_amount_factory" placeholder="0" value="" required=""/>
                </div>
                <div class="form-group col-xs-12">
                    <label for="detail_factory">รายละเอียดอื่นๆ</label>
                    <textarea rows="4" cols="50" id="detail_factory" name="detail_factory" class="form-control" placeholder="กรอกรายละเอียดอื่นๆ" value="" required=""/></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="submit_factory" class="btn btn-primary">Save changes</button>
    </div>
</form>
