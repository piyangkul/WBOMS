<?php include 'template.php';?>
 <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Add Product</h2>   
                            <h5>เพิ่มสินค้า </h5>

                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr />

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 col-sm-6 ">

                            <div class="form-group col-xs-12">
                                <div class="col-md-12 col-sm-12 ">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <label>สินค้า</label>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive ">
                                                <form class="form">
                                                    <div class="form-group col-xs-12">
                                                        <label for="exampleInputName1">รหัสสินค้า</label>
                                                        <input type="text" class="form-control" id="exampleInputName1" placeholder="กรอกรหัสสินค้า" >
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="exampleInputName2"> ชื่อสินค้า </label>
                                                        <input type="text" class="form-control" id="exampleInputName2" placeholder="กรอกชื่อสินค้า">
                                                    </div>
                                                    <div class="form-group col-xs-12">
                                                        <label for="exampleInputName3"> ชื่อโรงงาน </label>
                                                        <input type="text" class="form-control" id="exampleInputName3" placeholder="กรอกชื่อโรงงาน">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- หน่วยสินค้า -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>หน่วยสินค้า</label>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <a href="popup_add_product_unit.html" class="btn btn-info btn-lg" >
                                            <span class="glyphicon glyphicon-plus"></span> เพิ่มหน่วยสินค้า
                                        </a>
                                        <br><br>
                                                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                                    <thead>
                                                        <tr>
                                                            <th>จำนวนต่อหน่วยใหญ่</th>
                                                            <th>หน่วยใหญ่</th>
                                                            <th>จำนวนต่อหน่วยรอง</th>
                                                            <th>หน่วยรอง</th>
                                                            <th>การกระทำ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>มัด</td>
                                                            <td>2</td>
                                                            <td>กล่อง</td>
                                                            <td> 
                                                                <a href="popup_edit_product_unit.html" class="btn btn-warning ">
                                                                    <span class="glyphicon glyphicon-edit"></span>
                                                                </a>
                                                                <a href="#" class="btn btn-danger ">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>กล่อง</td>
                                                            <td>12</td>
                                                            <td>แพ็ค</td>
                                                            <td> 
                                                                <a class="btn btn-warning"  href="#" role="button">แก้ไข</a>
                                                                <a class="btn btn-danger"  href="#" role="button">ลบ</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>แพ็ค</td>
                                                            <td>6</td>
                                                            <td>ชิ้น</td>
                                                            <td> 
                                                                <a class="btn btn-warning"  href="#" role="button">แก้ไข</a>
                                                                <a class="btn btn-danger"  href="#" role="button">ลบ</a>
                                                            </td>
                                                        </tr>
                                                </table>
                                                </div>

                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                                <!--End หน่วยสินค้า -->

                                                <!-- ราคาสินค้า -->
                                                <div class="row ">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-5 col-sm-5 ">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <label>ราคาสินค้า</label>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="table-responsive ">
                                                                    <form class="form">
                                                                        <div class="form-group col-xs-12">
                                                                            <label for="disabledInput1">หน่วยใหญ่ที่สุด</label>
                                                                            <input type="text" class="form-control" id="disabledInput1" placeholder="มัด" disabled>
                                                                        </div>
                                                                        <div class="form-group col-xs-12">
                                                                            <label for="exampleInputName4"> ราคาเปิดต่อหน่วยใหญ่ที่สุด </label>
                                                                            <input type="text" class="form-control" id="exampleInputName4" placeholder="กรอกราคาเปิด">
                                                                        </div>
                                                                        <div class="form-group col-xs-12">
                                                                            <div class="col-md-12 col-sm-12 ">
                                                                                <div class="panel panel-info">
                                                                                    <div class="panel-heading">
                                                                                        <label>ต้นทุนลด</label>
                                                                                    </div>
                                                                                    <div class="panel-body">
                                                                                        <div class="table-responsive ">
                                                                                            <form class="form">
                                                                                                <label class="radio">
                                                                                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> เปอร์เซ็นต์
                                                                                                        <input type="text" class="form-control" placeholder="ใส่%ต้นทุนลด" id="userName" name="username" value="" /> 
                                                                                                </label>
                                                                                                <label class="radio">
                                                                                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> สุทธิไม่ลด
                                                                                                </label>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-xs-12">
                                                                            <label for="exampleInputName2"> ราคาต้นทุน </label>
                                                                            <input type="text" class="form-control" id="exampleInputName2" placeholder="560">
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--End ราคาสินค้า -->
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-3"></div>
                                                        <a href="product.html" class="btn btn-info btn-lg text-center">
                                                            <span class="glyphicon glyphicon-floppy-save"></span> บันทึก
                                                        </a>
                                                        <a href="#" class="btn btn-danger btn-lg text-center">
                                                            <span class="glyphicon glyphicon-floppy-remove"></span> ยกเลิก
                                                        </a>
                                                    </div>
                                                </div>
                                                </div>
                                                </div>

                                                <!-- /. PAGE INNER  -->
                                                </div>
                                                <!-- /. PAGE WRAPPER  -->