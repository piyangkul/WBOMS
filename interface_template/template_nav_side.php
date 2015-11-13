
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li class="text-center">
                <img src="../assets/img/find_user.png" class="img-circle" class="user-image img-responsive"/>
            </li>
            <li>
                <a <?php if($p=="history_order") echo 'class="active-menu"';?>  href="../interface_history_order/history_order.php"><span class="fa fa-dashboard fa-3x"></span> History Order</a>
            </li>
            <li>
                <a <?php if($p=="product") echo 'class="active-menu"';?> href="../interface_product/product.php"><i class="fa fa-desktop fa-3x"></i> Product </a>
            </li>
            <li>
                <a <?php if($p=="factory") echo 'class="active-menu"';?> href="../interface_factory/factory.php"><i class="fa fa-bar-chart-o fa-3x"></i> Factory</a>
            </li>	
            <li>
                <a <?php if($p=="shop") echo 'class="active-menu"';?> href="../interface_shop/shop.php"><i class="fa fa-table fa-3x"></i> Shop </a>
            </li>
            <li>
                <a <?php if($p=="membership") echo 'class="active-menu"';?> href="../membership/membership.php"><i class="fa fa-qrcode fa-3x"></i> Membership </a>
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
