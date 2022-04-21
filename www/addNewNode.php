<?php 
	require_once 'connectBD.php';
	$res = file_get_contents('newNode.json');
	$date = date('m/d/Y h:i:s a', time());
	if($date == null){
		file_put_contents('log.txt', "\n НЕ СРАботала функция получания текущего времени Хд", FILE_APPEND );
	}
	if ($res == null) {
		file_put_contents('log.txt', "\n".$date." Была попытка добавления, но json не получилось его прочесть", FILE_APPEND );
	} else {
		$res = json_decode($res,true);
		if($res[0]['pathImg']!=null && $res[0]['date']!=null && $res[0]['time']!=null){
			mysql_query("INSERT INTO `webtest`.`testtable` (`id`, `pathImg`, ` date`, `time`) VALUES (NULL, '".$res[0]['pathImg']."', '".$res[0]['date']."', '".$res[0]['time']."')");
				file_put_contents('log.txt', "\n".$date." Запись успешно добавилась ".$res[0]['pathImg']." ".$res[0]['date']." ".$res[0]['time'], FILE_APPEND );
		} else
			file_put_contents('log.txt', "\n".$date." Была попытка добавления, но в json некоторые переменные = null ".$res[0]['pathImg']." ".$res[0]['date']." ".$res[0]['time'], FILE_APPEND );
	}
	?>