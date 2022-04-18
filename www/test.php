<!doctype html>
<html>
<head>
  <style>
    .tree span:hover {
      font-weight: bold;
    }

    .tree span {
      cursor: pointer;
    }
  </style>
  <meta charset="utf-8">
<title>Main</title>
 </head>
<body>

<ul class="tree" id="tree">
	<li>Снимки за 22.02.01
	  <ul>
		<li>--Снимок от 15:30:12 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
		<li>--Снимок от 17:33:56 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
		<li>--Снимок от 20:51:31 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
		<li>--Снимок от 23:12:22 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
	  </ul>
	</li>
	<li>Снимки за 22.02.02
	  <ul>
		<li>--Снимок от 15:30:12 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
		<li>--Снимок от 17:33:56 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
		<li>--Снимок от 23:12:22 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
	  </ul>
	</li>
	<li>Снимки за 22.02.03
	  <ul>
		<li>--Снимок от 20:51:31 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
		<li>--Снимок от 23:12:22 <a href="img/img1.png">Открыть файл в браузере</a> <a href="img/img1.png" download>Скачать файл</a></li>
	  </ul>
	</li>
</ul>


	
	
	<script>
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