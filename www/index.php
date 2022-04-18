<!doctype html>
<html>
<head>
 <link rel="stylesheet" href="style.css">
<title>Main</title>
 </head>
<body>
<div class="container">
	<div>
		<ul class="tree" id="tree">
		<?php 
			$host='localhost'; // имя хоста 
			$database='webtest'; // имя базы данных
			$user='root'; // имя пользователя
			$pswd=''; // пароль


			$dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
			mysql_select_db($database) or die("Не могу подключиться к базе.");
			?> 
			<i><h3>Спутниковые снимки погоды</h3></i>
			<hr><hr> <?


			$query = "SELECT * FROM testtable ";
			$res = mysql_query($query); 
			$prev = null;
			$mas = null;
			while($row = mysql_fetch_array($res))
			{
				if ( $prev == null || $prev != $row[2]){					
					if ($prev != null){
						echo "</ul>"; ?>
						<?php
						echo "</li><br>";	
					}
					?>
					<li>Все снимки за <?php echo $row[2];?>
					<form class="subClassButton" action="buildArch.php?date=<?php echo $row[2];?>" method="post">
					<input type="submit" name="buildArch"  value="Скачать все снимки"> <br>
					</form>
					<hr>
					 <ul>
					<?php
					$mas .= " ".$row[2];
					$prev = $row[2];
				}?>
				<li> --Снимок за <?= $row[2]?> время = <?= $row[3]?> <br>
				<img src="img/<?= $row[1]?>.png" width="450" height="255">
				</li>
				<?php
			}
			?>
		</ul>
		<br><br>
		<hr><hr>
		<p>тестовая форма для новой записи в бд тест с крипта и тд (это не трогать)</p>
		<form action="script_tipa.php" method="post">
			<label>Введите имя картинки</label><br>
			<input type="text" name="pathImg"><br>
			<label>Введите дату</label><br>
			<input type="text" name="date"><br>
			<label>Введите время</label><br>
			<input type="text" name="time"><br>
			<br>
			<input type="submit" name="formSubmit" value="Добавить">
		</form>
	</div>
	<div>
		<!--<form action="script_tipa.php" method="post">
			<label>Введите имя картинки</label><br>
			<input type="text" name="pathImg"><br>
			<label>Введите дату</label><br>
			<input type="text" name="date"><br>
			<label>Введите время</label><br>
			<input type="text" name="time"><br>
			<br>
			<input type="submit" name="formSubmit" value="Добавить">
		</form>-->
	</div>
</div>
	
	
	<script>
	
	function pop_up(mas){
		var splitMas = mas.split();
		
	}
	
	
    // поместить все текстовые узлы в элемент <span>
    // он занимает только то место, которое необходимо для текста
    for (let li of tree.querySelectorAll('li')) {
      let span = document.createElement('span');
      li.prepend(span);
      span.append(span.nextSibling); // поместить текстовый узел внутрь элемента <span>
    }

    //  ловим клики на всём дереве
    tree.onclick = function(event) {

      if (event.target.tagName != 'SPAN') {
        return;
      }

      let childrenContainer = event.target.parentNode.querySelector('ul');
      if (!childrenContainer) return; // нет детей

      childrenContainer.hidden = !childrenContainer.hidden;
    }
  </script>
</body></html>