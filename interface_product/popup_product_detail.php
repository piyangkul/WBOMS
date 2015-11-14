<form class="form" action="product.php" method="post">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดสินค้า</h4>
    </div>
    <div class="row">
        <div class="col-md-10 col-sm-10 ">
            <div class="form-group col-xs-12">
                <div class="col-md-12 col-sm-12 ">
                </div>
                <div class="form-group col-xs-12">
                    <label for="disabledInput1">รหัสสินค้า</label>
                    <input type="text" class="form-control" id="disabledInput1" placeholder="A001" disabled>
                </div>
                <div class="form-group col-xs-12">
                    <label for="disabledInput2"> ชื่อสินค้า </label>
                    <input type="text" class="form-control" id="disabledInput2" placeholder="เยลลี่ 5 บาท" disabled>
                </div>
                <div class="form-group col-xs-12">
                    <label for="disabledInput3"> ชื่อโรงงาน </label>
                    <input type="text" class="form-control" id="disabledInput3" placeholder="A" disabled>
                </div>

                <!-- หน่วยสินค้า -->
                <div class="row">
                    <div class="col-md-2 col-sm-2 "></div>
                    <div class="col-md-12 col-sm-12 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>หน่วยสินค้า</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <br>
                                    <table class="table table-striped table-bordered table-hover text-center" 
                                           id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>จำนวนต่อหน่วยใหญ่</th>
                                                <th>หน่วยใหญ่</th>
                                                <th>จำนวนต่อหน่วยรอง</th>
                                                <th>หน่วยรอง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>มัด</td>
                                                <td>2</td>
                                                <td>กล่อง</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>กล่อง</td>
                                                <td>12</td>
                                                <td>แพ็ค</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>แพ็ค</td>
                                                <td>6</td>
                                                <td>ชิ้น</td>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End หน่วยสินค้า -->

                <!-- ราคาสินค้า -->
                <div class="row">
                    <div class="col-md-2 col-sm-2 "></div>
                    <div class="col-md-12 col-sm-12 ">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <label>ราคาสินค้า</label>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive ">
                                    <center>
                                        <h4>ต้นทุนลด 10 %</h4>
                                    </center>
                                    <table class="table table-striped table-bordered table-hover text-center" 
                                           id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>จำนวนต่อหน่วยใหญ่</th>
                                                <th>หน่วยใหญ่</th>
                                                <th>ราคาเปิด</th>
                                                <th>ราคาต้นทุน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>มัด</td>
                                                <td>560</td>
                                                <td>504</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>กล่อง</td>
                                                <td>280</td>
                                                <td>252</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>แพ็ค</td>
                                                <td>23.33</td>
                                                <td>21</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>ชิ้น</td>
                                                <td>3.88</td>
                                                <td>3.5</td>
                                            </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End ราคาสินค้า -->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id="submit" name="sumbit" value="addMem" class="btn btn-primary">Save changes</button>
    </div>
</form>