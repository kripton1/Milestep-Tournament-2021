<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

try{
	$db = new SQLite3('mydatabase.db');
}catch (Throwable $t){
	$db =  new SQLite3('../mydatabase.db');
}

if(!$db->query('SELECT id FROM users')){
	$db->exec('CREATE TABLE users (
	    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	    login varchar(255) NOT NULL,
	    password varchar(255) NOT NULL
	);');
}
if(!$db->query('SELECT id FROM events')){
	$db->exec('CREATE TABLE events (
	    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	    uid int NOT NULL,
	    title varchar(255) NOT NULL,
	    describtion varchar(255) NOT NULL,
	    date varchar(255) NOT NULL
	);');
}

function loginUser($login, $password){
	global $db;
	return $db->query('SELECT `id` FROM `users` WHERE `login` = "'.$login.'" and `password` = "'.$password.'"');
}

function registerUser($login, $password){
	global $db;
	$q = $db->exec('INSERT INTO `users`(`login`, `password`) VALUES("'.$login.'", "'.$password.'")');
	$id = $db->querySingle('SELECT `id` FROM `users` WHERE `login` = "'.$login.'" and `password` = "'.$password.'"');
	if($q == true){
		return $id;
	}else{
		return $q;
	}
}

function getEvents($time, $day){
	global $db;
	if(!$_COOKIE['__cdrId']) return false;
	$res = $db->query('SELECT `id`, `title`, `describtion` FROM `events` WHERE `uid` = "'.$_COOKIE['__cdrId'].'" and `date` = "'.$time.'-'.$day.'"');
	$res2 = [];
	while ($row = $res->fetchArray()) {
	    $res2[] = $row;
	}
	return $res2;
}

function addEvent($title, $describtion, $time, $day){
	global $db;
	if(!$_COOKIE['__cdrId']) return false;
	return $db->exec('INSERT INTO `events` (`uid`, `title`, `describtion`, `date`) VALUES("'.$_COOKIE['__cdrId'].'", "'.$title.'", "'.$describtion.'", "'.$time.'-'.$day.'")');
}

function deleteEvent($id){
	global $db;
	if(!$_COOKIE['__cdrId']) return false;
	return $db->exec('DELETE FROM `events` WHERE `uid` = "'.$_COOKIE['__cdrId'].'" and `id` = "'.$id.'"');
}

function editEvent($id, $title, $describtion){
	global $db;
	if(!$_COOKIE['__cdrId']) return false;
	return $db->exec('UPDATE `events` SET `title` = "'.$title.'", `describtion` = "'.$describtion.'" WHERE `uid` = "'.$_COOKIE['__cdrId'].'" and `id` = "'.$id.'"');
}





if(isset($_POST['jquery']) && $_POST['jquery'] == 'true'){
	if(isset($_POST['method'])){
		switch ($_POST['method']) {
			case 'getEvents':
				if(isset($_POST['time']) && isset($_POST['day'])){
					echo json_encode(getEvents($_POST['time'], $_POST['day']));
				}
				break;
			case 'addEvent':
				if(isset($_POST['time']) && isset($_POST['day']) && isset($_POST['title']) && isset($_POST['describtion'])){
					echo json_encode(addEvent($_POST['title'], $_POST['describtion'], $_POST['time'], $_POST['day']));
				}
				break;
			case 'deleteEvent':
				if(isset($_POST['id'])){
					echo json_encode(deleteEvent($_POST['id']));
				}
				break;
			case 'editEvent':
				if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['describtion'])){
					echo json_encode(editEvent($_POST['id'], $_POST['title'], $_POST['describtion']));
				}
				break;
				break;
			default:
				echo false;
				break;
		}
	}
	exit();
}