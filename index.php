<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>THIP WAREE Project</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- MORRIS CHART STYLES-->
        <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<!--
        <script language ="javascript">
            function CheckForm() {
                if (login.username.value == '' && login.password.value == '') {
                    login.username.focus();
                    login.password.focus();
                    return false;
                }
            }
            function CheckCorrect() {
                if (login.username.value == '#') {
                    alert('คุณกรอก Username ผิด')
                    login.username.focus();
                    return false;
                }
                else if (login.password.value == '#') {
                    alert('คุณกรอก Password ผิด')
                    login.password.focus();
                    return false;
                }

            }
        </script>
-->
    </head>
    <body>
        <center>
            <div class="container" style="margin-top: 20px">
                <div class="row">
                    <div class="page-header">
                        <h1>Login</h1>
                    </div>
                </div> 
            </div>
        </center>  
        <div class="col-md-4"></div>
        <div class="container col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form name="login_form" method="post" action="login/action/action_login.php" >
                                <div class="form-group">
                                    <label>Username :</label>
                                    <input type="text" class="form-control" placeholder="Enter Username" name="username" value="" required=""/>       
                                </div>
                                <div class="form-group">    
                                    <label>Password : </label>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" value="" required=""/>
                                </div>
                                <div class="form-group">
                                    <center>
                                        <input class="btn btn-primary" type="submit" name="submit" value="Enter"/>
                                    </center>
                                </div>
                                <?php
                                if (isset($_REQUEST['error'])) {
                                    if ($_REQUEST['error'] == 2) {
                                        echo '<br>Username หรือ Password ผิดนะ';
                                    } /*elseif ($_REQUEST['error'] == 3) {
                                        echo '<br>ลืมใส่อะไรป่าว  Login ใหม่จ้า';
                                    }*/
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
