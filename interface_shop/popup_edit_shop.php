<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>THIP WAREE Project</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head>
    <body>
        <br>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="form-group col-xs-12">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>แก้ไขร้านค้า</label>
                                </div>
                                <div class="panel panel-body">
                                    <div class="table-responsive ">
                                        <form class="form">
                                            <div class="form-group col-xs-12">
                                                <label for="name_factory">ชื่อร้านค้า</label>
                                                <input type="text" class="form-control" id="name_factory" placeholder="กรอกชื่อร้านค้า">
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="Tel">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" id="Tel" placeholder="กรอกเบอร์โทรศัพท์ร้านค้า" >
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="address">ที่อยู่</label>
                                                <textarea rows="4" cols="50" name="address" form="usrform" class="form-control" placeholder="กรอกที่อยู่ร้านค้า"></textarea>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="region">ภูมิภาค</label>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" name ="region">
                                                        กรุณาเลือกภูมิภาค<span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu" >
                                                        <li><a href="#">ภาคกลาง</a></li>
                                                        <li><a href="#">ภาคใต้</a></li>
                                                        <li><a href="#">ภาคเหนือ</a></li>
                                                        <li><a href="#">ภาคตะวันออก</a></li>
                                                        <li><a href="#">ภาคตะวันตก</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="province">จังหวัด</label>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" name="province">
                                                        กรุณาเลือกจังหวัด<span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="#">กรุงเทพ</a></li>
                                                        <li><a href="#">นครปฐม</a></li>
                                                        <li><a href="#">สุพรรณบุรี</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="exampleInputName2">รายละเอียดอื่นๆ</label>
                                                <textarea rows="4" cols="50" name="Other" form="usrform" class="form-control" placeholder="กรอกรายละเอียดอื่นๆ"></textarea>
                                            </div>
                                        </form>

                                        <div class="row">

                                        </div>
                                        <div class="modal-footer">
                                            <a href="edit_product.html" class="btn btn-default" data-dismiss="modal">
                                                ยืนยัน
                                            </a>
                                            <a href="#" class="btn btn-primary ">
                                                ยกเลิก
                                            </a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
            <!-- JQUERY SCRIPTS -->
            <script src="assets/js/jquery-1.10.2.js"></script>
            <!-- BOOTSTRAP SCRIPTS -->
            <script src="assets/js/bootstrap.min.js"></script>
            <!-- METISMENU SCRIPTS -->
            <script src="assets/js/jquery.metisMenu.js"></script>
            <!-- CUSTOM SCRIPTS -->
            <script src="assets/js/custom.js"></script>
    </body>
</html>
