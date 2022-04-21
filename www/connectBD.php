<?php
	$host='localhost'; // имя хоста 
	$database='webtest'; // имя базы данных
	$user='root'; // имя пользователя
	$pswd=''; // пароль
	$dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
	mysql_select_db($database) or die("Не могу подключиться к базе.");
?>