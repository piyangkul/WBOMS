<!--<form class="form" action="add_product.php" method="POST">-->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">แก้ไขหน่วยสินค้า</h4>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-12">
                <p id="alert"></p>
            </div>
            <form class="form">
                <div class="form-group col-xs-12">
                    <label for="exampleInputName1">ชื่อหน่วยสินค้ารอง</label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="ใส่หน่วยสินค้า เช่น(กล่อง)">
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName3">จำนวนต่อหน่วยรอง</label>
                    <input type="text" class="form-control" id="exampleInputName3" placeholder="ใส่จำนวนต่อหน่วยรอง เช่น(2)" >
                </div>
                <div class="form-group col-xs-12">
                    <label for="exampleInputName2">หน่วยใหญ่ที่จะเปรียบเทียบ</label>
                </div>
                <div class="form-group col-xs-12">
                    <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            กรุณาเลือกหน่วย<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">มัด</a></li>
                            <li><a href="#">กล่อง</a></li>
                            <li><a href="#">แพ็ค</a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single button -->

                <div class="form-group col-xs-12">
                    <label for="disabledInput1">ราคาต่อหน่วยสินค้า</label>
                    <input type="text" class="form-control" id="disabledInput1" placeholder="280" disabled>
                </div>
                <div class="form-group col-xs-12">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <label>ประเภทหน่วยสินค้า</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive ">
                                    <label class="radio">
                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ขาย
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> ไม่ขาย
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" onclick="addUnit();" class="btn btn-primary">Save changes</button>
</div>