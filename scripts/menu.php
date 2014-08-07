<?php
session_start();
if ($_SESSION['logueado']==true){ ?>
<div class="sidebar-nav">
<nav class="navbar navbar-inverse" role="navigation" style="padding-top:10px;padding-bottom:10px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"></a>
    </div>
    <?php 
    $nav = ($_GET['nav'] ? $_GET['nav'] : 'home');
    ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php echo ($nav=="inicio") ? 'class="active"' : ''; ?> ><a href="/index.php?nav=inicio">Inicio</a></li>
        <li <?php echo ($nav=="store") ? 'class="active"' : ''; ?> ><a href="/index.php?nav=store">Mi Tienda</a></li>
        <li <?php echo ($nav=="productos" || $nav=="newproduct" || $nav=="editproduct") ? 'class="active"' : ''; ?> ><a href="/index.php?nav=productos">Mis Productos</a></li>
        <li <?php echo ($nav=="ventas") ? 'class="active"' : ''; ?> ><a href="/index.php?nav=ventas">Mis Ventas</a></li>
        <li <?php echo ($nav=="configuracion") ? 'class="active"' : ''; ?> ><a href="/index.php?nav=configuracion">Configuración</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>

<?php }else{ ?>

<?php } ?>