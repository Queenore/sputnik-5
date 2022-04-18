<?php 
	if( isset( $_POST['pathImg']) && isset( $_POST['date']) && isset( $_POST['time']) )
	{
		$substr =  "pathImg =".$_POST['pathImg']." date =".$_POST['date']." time =".$_POST['time'];
		file_put_contents('log.txt', "\n".$substr, FILE_APPEND );
	}else{
		file_put_contents('log.txt', "\nБыла попытка не вышло гг", FILE_APPEND );
	}
	?>