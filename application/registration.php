<?php
if(isset($_COOKIE['__cdr']) && $_COOKIE['__cdr'] == 'true'){
	header('Location: /');
}

require_once '../db.php';
if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password2'])){
	$login = $_POST['login'];
	$pass = $_POST['password'];
	$pass2 = $_POST['password2'];
	if($pass != $pass2){
		$error = 'Пароли не совпадают!';
	}else{
		$q = registerUser($login, $pass);
		if($q){
			setcookie('__cdr', 'true', time()+60*60*24, '/');
			setcookie('__cdrId', $q, time()+60*60*24, '/');
			header('Location: /');
		}else{
			$error = $q;
		}
	}
}


$title = 'Регистрация';

ob_start();
?>
<div class="row mt-4">
	<div class="col-sm-4"></div>
	<div class="col-sm-4 border border-warning rounded p-3">
		<form class="row g-3" method="POST" action>
			<div class="col-12">
				<label for="login" class="form-label">Логин</label>
				<input type="text" class="form-control" id="login" name="login">
			</div>
			<div class="col-12">
				<label for="password" class="form-label">Пароль</label>
				<input type="password" class="form-control" id="password" name="password">
			</div>
			<div class="col-12">
				<label for="password2" class="form-label">Повторите пароль</label>
				<input type="password" class="form-control" id="password2" name="password2">
			</div>
			<?php if(isset($error) && $error != ''){ ?>
			<div class="alert alert-danger" role="alert">
			<?=$error?>
			</div>
			<?php } ?>
			<div class="col-12">
				<button type="submit" class="btn btn-primary">Зарегистрироваться</button>
				<p class="small text-muted">Регистрируясь вы принимаете <a href="#">какой-то непонятный документ</a></p>
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