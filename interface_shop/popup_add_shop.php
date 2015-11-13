<html xmlns="http://www.w3.org/1999/xhtml">
    <?php require '../model/db_user.inc.php'; ?>
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
        <!--  CONNECT DATABASE  -->
        <br>
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="form-group col-xs-12">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <label>เพิ่มร้านค้า</label>
                                </div>
                                <div class="panel panel-body">
                                    <div class="table-responsive ">
                                        <form class="form">
                                            <div class="form-group col-xs-12">
                                                <label for="name_shop">ชื่อร้านค้า</label>
                                                <input type="text" class="form-control" name="name_shop" placeholder="กรอกชื่อร้านค้า">
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="tel_shop">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" name="tel_shop" placeholder="กรอกเบอร์โทรศัพท์ร้านค้า" >
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="address_shop">ที่อยู่</label>
                                                <textarea rows="4" cols="50" name="address_shop" class="form-control" placeholder="กรอกที่อยู่ร้านค้า"></textarea>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="region">ภูมิภาค</label>
                                                <div class="btn-group">
                                                    <script>
                                                        function dd() {
                                                            var chgValue = document.getElementById("aa").value;
                                                            //alert(chgValue);
                                                            if (chgValue == "cc") {
                                                                document.getElementById("center").style.display = "block";
                                                                document.getElementById("nnn").style.display = "none";
                                                                document.getElementById("center").disabled = false;
                                                                document.getElementById("nnn").disabled = true;

                                                            }
                                                            else if (chgValue == "nn") {
                                                                document.getElementById("nnn").style.display = "block";
                                                                document.getElementById("center").style.display = "none"
                                                                document.getElementById("nnn").disabled = false;
                                                                document.getElementById("center").disabled = true;
                                                            }

                                                        }
                                                    </script>
                                                    <select id="aa" class="form-control" onchange="dd();">
                                                        <?php
                                                        
                                                        $res = get_region();
                                                    
                                                        while ($re = $res->fetch(PDO::FETCH_OBJ)) {
                                                            echo "<option value=\"$re->idregion\">$re->name_region</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-xs-12">
                                                <label for="province">จังหวัด</label>
                                                <div class="btn-group">
                                                    <select id="aaa" class="form-control" onchange="dd();">
                                                        <?php
                                                        $res = get_province($re);
                                                        while ($pro = $res->fetch(PDO::FETCH_OBJ)) {
                                                            echo "<option value=\"$pro->idprovince\">$pro->name_province</option>";
                                                        }
                                                        ?>
                                                    </select>
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
                                            <a href="#" class="btn btn-default" data-dismiss="modal">
                                                เพิ่ม
                                            </a>
                                            <a href="../interface_shop/shop.php" class="btn btn-primary ">
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
