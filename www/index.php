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
			<hr><hr> <?php
			
			$prev = null;
			$mas = null;
			foreach($connection->query('SELECT * FROM testtable') as $row) 
			{
				if ( $prev == null || $prev != $row[2]){					
					if ($prev != null){
						echo "</ul>"; 
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
			echo "<br>Количество снимков ".$connection->query('SELECT * FROM testtable')->rowCount();
			?>
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