<?php
require_once dirname(__FILE__) . '/../function/func_docket.php';
?>
<?php 
$idregion = $_GET['idregion'];
?>
<option value="" >ทุกจังหวัด</option>
<?php
$getProvince = getProvinceByIDRegion($idregion);
foreach ($getProvince as $value) {
    $idprovince = $value['idprovince'];
    $name_province = $value['name_province'];
    $code_province = $value['code_province'];
    echo "<option value = $idprovince> $name_province </option>";
}
?>  