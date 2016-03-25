<!--<option selected value="">Choose</option>-->
<?php
require_once 'function/func_discount_shop.php';
$get_searchProduct = $_GET['searchProduct'];
$getProductByName = getProductByName($get_searchProduct);
//$getProducts = getProducts();
foreach ($getProductByName as $value) {
//    if ($value['idunit_big'] != NULL) {
//        continue;
//    }
    $val_idproduct = $value['idproduct'];
    $val_name_product = $value['name_product'];
    $val_name_factory = $value['name_factory'];
    $val_product_code = $value['product_code'];
    ?>
    <option value="<?php echo $val_idproduct; ?>"><?php echo "[$val_product_code] $val_name_product - $val_name_factory"; ?></option>
<?php } ?>