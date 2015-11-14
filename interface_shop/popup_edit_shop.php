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
        <?php
        if (isset($_GET['idshop_edit'])) {
            $idshop_edit = $_GET['idshop_edit'];

            $result = get_shop_id($idshop_edit);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            ?>
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
                                            <form class="form" action="shop_process.php" method="post">
                                                <div class="form-group col-xs-12">
                                                    <label for="exampleInputName1">รหัสร้านค้า</label>
                                                    <input type="text" class="form-control" name="idshop_edit" placeholder="กรอกชื่อโรงงาน"  value = "<?php echo $row["idshop"] ?>">
                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <label for="name_shop">ชื่อร้านค้า</label>
                                                    <input type="text" class="form-control" name="name_shop_edit" placeholder="กรอกชื่อร้านค้า" value = "<?php echo $row["name_shop"] ?>">
                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <label for="tel_shop">เบอร์โทรศัพท์</label>
                                                    <input type="text" class="form-control" name="tel_shop_edit" placeholder="กรอกเบอร์โทรศัพท์ร้านค้า"  value = "<?php echo $row["tel_shop"] ?>">
                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <label for="address_shop">ที่อยู่</label>
                                                    <textarea rows="4" cols="50" name="address_shop_edit" class="form-control" placeholder="กรอกที่อยู่ร้านค้า" ><?php echo $row["address_shop"] ?></textarea>
                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <label for="province">จังหวัด</label>
                                                    <div class="btn-group">
                                                        <select id="aaa" name="idprovince_shop_edit" class="form-control" onchange="dd();">
                                                            <?php
                                                            $res = get_province();
                                                            while ($pro = $res->fetch(PDO::FETCH_OBJ)) {
                                                                echo "<option name ='idprovince_shop_edit' value = $pro->idprovince>$pro->name_province</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-xs-12">
                                                    <label for="detail_factory">รายละเอียดอื่นๆ</label>
                                                    <textarea rows="4" cols="50" id="detail_factory" name="detail_shop_edit" class="form-control" placeholder="กรอกรายละเอียดอื่นๆ" value="" required=""><?php echo $row["detail_shop"]; ?></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-default" type="submit" name="submit">
                                                        แก้ไข
                                                    </button>
                                                    <a href="shop.php" class="btn btn-primary ">
                                                        ยกเลิก
                                                    </a>
                                                </div>
                                            </form>
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
                <?php
            }
            ?>
    </body>
</html>
