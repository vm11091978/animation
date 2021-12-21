<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>Анимация: кораблик, плывущий по волнам</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="">
    <link type="image/x-icon" rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

	<div id="top">
		<span id="doc_time">Вы находитесь на странице секунд:</span>
		<div id="sun">
			<div id="circle"></div>
		</div>
	</div>

	<div id="wave">
		<img id="boat" src="boat.png" alt="">
		<?php
			for ($i = 1; $i <= 580; $i++) {
				$num = "el".$i;
				// $height = 90 + 10*sin($i/10);
				echo "<div id='$num' style = 'width: 1px; height: ".$height."px; background-image: linear-gradient(deepskyblue, #0078FF)'></div>";
			}
		?>
	</div>

	<div id="bottom"></div>

	<script type="text/javascript">
		let count = 0;
		function clock()
		{
			document.getElementById("doc_time").innerHTML = "Вы находитесь на странице секунд: " + Math.floor(count);
			count += 0.1;
			/* setTimeout("clock()", 1000); */
		}
		/* clock(); */

		let change = 0;
		function sunrise()
		{
			let sun = document.getElementById("sun");
			let circle = document.getElementById("circle");

			let j = 0.005*change;
			if (change > 314) {
				j = 1.57;
			}
			sun.style.top = 360 * (1 - Math.sin(j)) + 'px';

			let diam = 90 + 3*Math.sin(0.3*change);
			circle.style.width = diam + 'px';
			circle.style.height = diam + 'px';
			change++;
		}

		let i = 0;
		function color()
		{
			if (i <= 255) {
				color1 = 255; color2 = i; color3 = 0;
			}
			else if (i <= 510) {
				color1 = 510 - i; color2 = 255; color3 = 0;
			}
			else if (i <= 765) {
				color1 = 0; color2 = 255; color3 = i - 510;
			}
			else if (i <= 1020) {
				color1 = 0; color2 = 1020 - i; color3 = 255;
			}
			else if (i <= 1275) {
				color1 = i - 1020; color2 = 0; color3 = 255;
			}
			else if (i < 1530) {
				color1 = 255; color2 = 0; color3 = 1530 - i;
			}
			else {
				color1 = 255; color2 = 0; color3 = 0;
				i = 0;
			}
			circle.style.background = 'rgb(' + color1 + ', ' + color2 + ', ' + color3 + ')';
			/* гориз. и верт. смещение тени, радиус размытия, растяжение, цвет (если внутрь - inset) */
			circle.style.boxShadow = '0px 0px 50px 0px rgb(' + color1 + ', ' + color2 + ', ' + color3 + ')';

			i++;
		}
		/* переломные точки: 255 255 0, 0 255 0, 0 255 255, 0 0 255, 255 0 255, 255 0 0, */

		let k = 0; let l = 0; let m = 0;
		function wafe()
		{
			let j = 10*Math.sin(0.1*k); // первое число - высота волн, второе - скорость
			/* 	el1.style.height = 90 + j*0.099833416646828 + 'px'; */
			/*	el1.style.height = 90 + j*Math.sin(1/11.2) + 'px'; */

			<?php
				for ($i = 1; $i <= 580; $i++) {
					// задаём шаг волны: 11.2 * 2пи = 70 px, а так же движение волн вперёд:
					$height = "el$i.style.height = "."110 + j*Math.sin($i/11-k/22) + 'px';";
					echo $height;
				}
			?>
			if (m == 0 && !(Math.abs(j) < 0.2 && Math.sin(0.15*k) > 0.8 && k > 1500)) {
				boat.style.bottom = 110 + Math.abs(j) + 'px'; // движение кораблика вверх-вниз
				// максимальная вертикальная скорость 10 px/секунду при setTimeout = 10
				if (l <= 380) {
					boat.style.left = l + 'px';  // придадим движение кораблику вперёд
				} else if (l <= 761) {
					boat.style.left = 761 - l + 'px';  // и назад
				} else l = 0;
				// придадим покачивание (максимальная скорость вращения 3 градуса/секунду):
				boat.style.transform = 'rotate(' + 2*Math.sin(0.15*k) + 'deg)';
			}
			else if (m <= 130) { // затопим кораблик
				m++;
				boat.style.bottom = 108 - 0.7*m + 'px'; // 90 - 0.57*m + 'px'; при height = 90 
				boat.style.transform = 'rotate(' + 0.3*m + 'deg)';
			}
			
			k++;
			l++; // эта переменная обнуляется при возвращении кораблика в исходное положение
		}
		
		let timer = setInterval("clock(), wafe(), color(), sunrise()", 100);
		// или так: setInterval(function() {animate1(); animate2(); animate3(); }, 100);
	</script>

</body>
</html>