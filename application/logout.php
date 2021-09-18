<?php
if(isset($_COOKIE['__cdr']) && $_COOKIE['__cdr'] == 'true'){
	setcookie('__cdr', '', time()-3600, '/');
	header('Location: /');
}
?>