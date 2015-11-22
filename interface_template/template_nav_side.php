
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li class="text-center">
                <img src="../assets/img/find_user.png" class="img-circle" class="user-image img-responsive"/>
            </li>
            <li>
                <a <?php if($p=="history_order") echo 'class="active-menu"';?>  href="../interface_order/order.php"><span class="fa fa-folder-open-o fa-3x"></span> Order </a>
            </li>
            <li>
                <a <?php if($p=="product") echo 'class="active-menu"';?> href="../interface_product/product.php"><i class="fa fa-cube fa-3x"></i> Product </a>
            </li>
            <li>
                <a <?php if($p=="factory") echo 'class="active-menu"';?> href="../interface_factory/factory.php"><i class="fa fa-building-o fa-3x"></i> Factory</a>
            </li>	
            <li>
                <a <?php if($p=="shop") echo 'class="active-menu"';?> href="../interface_shop/shop.php"><i class="fa fa-shopping-cart fa-3x"></i> Shop </a>
            </li>
            <li>
                <a <?php if($p=="transport") echo 'class="active-menu"';?> href="../transport/transport.php"><i class="fa fa-truck fa-3x"></i> Transportation </a>
            </li>
            <li>
                <a <?php if($p=="shipment") echo 'class="active-menu"';?> href="../shipment/shipment1.php"><i class="fa fa-road fa-3x"></i> Shipment </a>
            </li>
            <li>
                <a <?php if($p=="membership") echo 'class="active-menu"';?> href="../membership/membership.php"><i class="fa fa-users fa-3x"></i> Membership </a>
            </li>
            
            <!--
            <li>
                <a href="#"><i class="fa fa-sitemap fa-3x"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Second Level Link</a>
                    </li>
                    <li>
                        <a href="#">Second Level Link</a>
                    </li>
                    <li>
                        <a href="#">Second Level Link<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">Third Level Link</a>
                            </li>
                            <li>
                                <a href="#">Third Level Link</a>
                            </li>
                            <li>
                                <a href="#">Third Level Link</a>
                            </li>

                        </ul>

                    </li>
                </ul>
            </li>  
            
            <li>
                <a  href="#"><i class="fa fa-square-o fa-3x"></i> Blank Page</a>
            </li>
            -->
        </ul>
    </div>
</nav>  
<!-- /. NAV SIDE  -->
