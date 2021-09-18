<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<title>CDR | <?=$title?></title>
	<?php if(isset($_COOKIE['__cdr']) && $_COOKIE['__cdr'] == 'true'){ ?>
	<link rel="stylesheet" type="text/css" href="./assets/css/home.css">
	<?php } ?>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
		<a class="navbar-brand" href="/">CDR</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#openMobileMenu" aria-controls="openMobileMenu" aria-expanded="false" aria-label="Open Mobile Menu">
		  	<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="openMobileMenu">
		  	<ul class="navbar-nav me-auto mb-2 mb-lg-0">
		    	<li class="nav-item">
		      		<a class="nav-link" href="/">Главная</a>
		    	</li>
		  	</ul>
		  	<div class="d-flex">
		  		<?php if(!isset($_COOKIE['__cdr']) || $_COOKIE['__cdr'] != 'true'){ ?>
		    	<a class="btn btn-outline-warning mx-2" type="button" href="/application/login.php">Войти</a>
		    	<a class="btn btn-outline-warning" type="button" href="/application/registration.php">Регистрация</a>
		    	<?php }else{ ?>
		    	<a class="btn btn-outline-warning mx-2" type="button" href="/application/logout.php">Выйти</a>
		    	<?php } ?>
			</div>
		</div>
		</div>
	</nav>

	<div class="conteiner">
		<?=$body?>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<?php if(isset($_COOKIE['__cdr']) && $_COOKIE['__cdr'] == 'true'){ ?>
	<script type="text/javascript" src="./assets/js/home.js"></script>
	<?php } ?>

</body>
</html>
