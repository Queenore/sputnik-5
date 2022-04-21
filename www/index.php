<!doctype html>
<html>
<head>
 <link rel="stylesheet" href="style.css">
 <link rel="stylesheet" href="dist/css/lightbox.css">
<title>Main</title>
 </head>
<body>
<div class="container">
	<div>
		<ul class="tree" id="tree">
		<?php 
			require_once 'connectBD.php';
			?> 
			<i><h3>Спутниковые снимки погоды</h3></i>
			<hr><hr> <?
			$query = "SELECT * FROM testtable ORDER BY 3 DESC";
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
					<li class ="select">Все снимки за <?php echo $row[2];?>
					<form class="subClassButton" action="buildArch.php?date=<?php echo $row[2];?>" method="post">
					<input type="submit" name="buildArch"  value="Скачать все снимки"> <br>
					</form>
					<hr>
					 <ul hidden class="vlozen" id="vlozen">
					<?php
					$mas .= " ".$row[2];
					$prev = $row[2];
				}?>
				<li> --Снимок за <?= $row[2]?> время = <?= $row[3]?> <br>
				<a href="img/<?= $row[1]?>.png" data-lightbox="test"><img src="img/<?= $row[1]?>.png" width="450" height="255" alt="no-image"></a>
				</li>
				<?php
			}
			?>
		</ul>
		<br><br>
		<hr><hr>
		<?php
			$qur=mysql_query("SELECT * FROM testtable");
			echo "<br>Количество снимков ".mysql_num_rows($qur);
		?>

		
		
		
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
	
	<script src="dist/js/lightbox-plus-jquery.min.js"></script>
	<script>
    for (let li of tree.querySelectorAll('li')) {
      let span = document.createElement('span');
      li.prepend(span);
      span.append(span.nextSibling); 
    }

    tree.onclick = function(event) {

      if (event.target.tagName != 'SPAN') {
        return;
      }

      let childrenContainer = event.target.parentNode.querySelector('ul');
      if (!childrenContainer) return; 

      childrenContainer.hidden = !childrenContainer.hidden;
    }
  </script>
</body></html>