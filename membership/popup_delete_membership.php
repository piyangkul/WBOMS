<!--  CONNECT DATABASE  -->
<?php
session_start();
require '../model/db_user.inc.php';
?>
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
                                    <label>ลบสมาชิก</label>
                                </div>
                                <div class="panel panel-body">
                                    <div class="table-responsive ">
                                        <form class="form" action="membership.php" method="post">
                                            <div class="form-group col-xs-12">
                                                <label>คุณต้องการลบ <? $_GET['id'] ?>ใช่ไหม </label>
                                            </div>
                                            <div class="row">

                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-default" type="submit" id="sumbit" name="sumbit">
                                                    ลบ
                                                </button>
                                                <a href="membership.php" class="btn btn-primary ">
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
    </body>
</html>
