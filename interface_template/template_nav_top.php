<?php
include('../config/connection.php');
?>
<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../interface_history_order/history_order.php">THIP <small>WAREE</small></a> 
    </div>
    <div style="color: white;
         padding: 15px 50px 5px 50px;
         float: right;
         font-size: 16px;"> <?php echo $_SESSION['username']['name'] . ' ' . $_SESSION['username']['lastname'] ?> &nbsp; 
        <a href="../deleteSession.php" class="btn btn-danger square-btn-adjust">Logout</a> </div>
</nav>   
<!-- /. NAV TOP  -->

