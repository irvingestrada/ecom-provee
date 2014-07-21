<?php
session_start();
if ($_SESSION['logueado']==false){ ?>
<form class="navbar-form navbar-right" role="form" method="post" action="/scripts/proc_login.php">
	<div class="form-group">
  	<input type="text" placeholder="Email" class="form-control" id="form_username" name="form_username">
	</div>
	<div class="form-group">
  	<input type="password" placeholder="Password" class="form-control" id="form_pass" name="form_pass">
	</div>
	<button type="submit" class="btn btn-success">Iniciar Sesion</button>
</form>
<?php }else{ ?>
<form class="navbar-form navbar-right" role="form" method="post" action="/scripts/proc_logout.php">
	<div class="form-group" style="color:white;">
  	<?php echo $_SESSION['nombre_sesion']; ?>
	</div>
	<button type="submit" class="btn btn-success">Cerrar Sesion</button>
</form>
<?php } ?>