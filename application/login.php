<?php
if(isset($_COOKIE['__cdr']) && $_COOKIE['__cdr'] == 'true'){
	header('Location: /');
}

if(isset($_POST['login']) && isset($_POST['password'])){
	$login =  $_POST['login'];
	$password = $_POST['password'];
	require_once '../db.php';
	$q = loginUser($login, $password);
	if($q){
		setcookie('__cdr', 'true', time()+60*60*24, '/');
		setcookie('__cdrId', $q, time()+60*60*24, '/');
		header('Location: /');
	}else{
		$error = 'Неверный логин или пароль!';
	}

	exit();
}

$title = 'Вход';

ob_start();
?>
<div class="row mt-4">
	<div class="col-sm-4"></div>
	<div class="col-sm-4 border border-warning rounded p-3">
		<form class="row g-3" method="POST">
			<div class="col-12">
				<label for="login" class="form-label">Логин</label>
				<input type="text" class="form-control" id="login" name="login">
			</div>
			<div class="col-12">
				<label for="password" class="form-label">Пароль</label>
				<input type="password" class="form-control" id="password" name="password">
			</div>
			<div class="col-12">
				<?php if(isset($error) && $error != ''){ ?>
				<div class="alert alert-danger" role="alert">
				<?=$error?>
				</div>
				<?php } ?>
				<button type="submit" class="btn btn-primary">Войти</button>
				<a href="#">Забыл пароль</a>
			</div>
		</form>
	</div>
	<div class="col-md-4"></div>
</div>
<?php
$body = ob_get_contents();
ob_end_clean();

require_once '../render.php';
?>