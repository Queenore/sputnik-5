<?php
	$host='localhost'; // имя хоста 
	$dbname='webtest'; // имя базы данных
	$username='root'; // имя пользователя
	$password=''; // пароль
	
	try {
		$connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
	} catch (PDOException $pe) {
	die("Could not connect to the database $dbname :" . $pe->getMessage());
	}
?>