<?php
require_once 'function/func_shipment.php';
?>
<?php
if (isset($_GET['idfactory'])) {
    $idfactory = $_GET['idfactory'];
    $getFactorys = getFactoryByID($idfactory);
    $val_name_factory = $getFactorys['name_factory'];
    $val_tel_factory = $getFactorys['tel_factory'];
    $val_address_factory = $getFactorys['address_factory'];
    $val_contact_factory = $getFactorys['contact_factory'];
    $val_difference_amount = $getFactorys['difference_amount_factory'];
    $val_detail_factory = $getFactorys['detail_factory'];
}
?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>THIP WAREE Project</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- MORRIS CHART STYLES-->
    <link href="../assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
</head>
﻿<form class="form" action="action/action_editShipment.php?idshipment=<?php echo $idfactory; ?>" method="get">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">รายละเอียดสินค้าตามบิลขนส่ง</h4>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="form-group col-xs-12">
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_factory">ชื่อโรงงาน</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-building"></i></span>
                        <input type="text" class="form-control" id="name_factory" name="name_factory" value="<?php echo $val_name_factory; ?>"disabled="">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="idorder_p">จากเลขที่บิลสั่งซื้อ</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                        <input type="text" class="form-control" id="idorder_p" name="idorder_p" value="<?php echo $val_tel_factory; ?>"disabled="">
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="date_order_p">วันที่สั่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                        <input type="date" class="form-control" id="date_order_p" name="date_order_p" value="<?php echo $val_contact_factory; ?>"disabled="" >
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_shop">ชื่อร้านค้า</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                        <input type="text" class="form-control" id="name_shop" name="name_shop" value="<?php echo $val_difference_amount; ?>"disabled="" >
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <label>ตารางรายการสินค้า</label>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                    <thead>
                        <tr>
                            <th><div align="center">ลำดับ</div></th>
                    <th><div align="center">ชื่อสินค้า</div></th>
                    <th><div align="center">หน่วยสินค้า</div></th>
                    <th><div align="center">ราคาเปิดต่อหน่วย</div></th>
                    <th><div align="center">จำนวน</div></th>
                    <th><div align="center">ต้นทุนลด</div></th>
                    <th><div align="center">ราคาต้นทุน</div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
//                        $getMembers = getMembers();
//                        $i = 0;
//                        foreach ($getMembers as $value) {
//                            $i++;
//                            $val_idmember = $value['idmember'];
//                            $val_name = $value['name'];
//                            $val_lastname = $value['lastname'];
//                            $val_username = $value['username'];
//                            
                        ?>
                            <!--<tr>-->
<!--                                <td><?php echo $i; ?></td>
                                <td><?php echo $val_name; ?></td>
                                <td><?php echo $val_lastname; ?></td>
                                <td><?php echo $val_username; ?></td>
                                <td><?php ?></td>
                                <td><?php ?></td>
                                <td><?php ?></td>-->
                        <!--</tr>-->
                        <?php // }  ?>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <label>ข้อมูลการขนส่ง</label>
        </div>
        <div class="panel-body">
            <div class="table-responsive ">
                <div class="form-group col-xs-12">
                    <label for="date_transport">วันที่ส่ง</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                        <input type="date" class="form-control" id="date_transport" value="" disabled>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="name_transport"> ชื่อบริษัทขนส่ง </label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-truck"></i></span>
                        <input type="text" class="form-control" id="name_transport" disabled>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="volume">เล่มที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-file"></i></span>
                        <input type="text" class="form-control" id="volume" name="volume" disabled >
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label for="number">เลขที่</label>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-file"></i></span>
                        <input type="text" class="form-control" id="number" name="number" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
