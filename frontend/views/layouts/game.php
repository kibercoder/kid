<?php
use yii\helpers\Html;
use frontend\assets\GameAsset;
$GameAsset = new GameAsset();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title) ?></title>
	<script type="text/javascript" src="<?=$GameAsset->baseUrl ?>/lib.min.js"></script>
    <script type="text/javascript" src="<?=$GameAsset->baseUrl ?>/app.min.js"></script>
    <?php //$this->head() ?>
    <script>
		function onResize(e) {
			var canvas = document.getElementById('canvas');

			var width = window.innerWidth;
			var height = window.innerHeight;

			canvas.style.width = width + 'px';
			canvas.style.height = height + 'px';

			canvas.width = width;
			canvas.height = height;
		}

		window.addEventListener('load', function () {
			WebFont.load({
				timeout: 2000,
				events: true,
				custom: {
					families: ['Myriad-Pro-Light-Condensed', 'AdonisC-Normal', 'AdonisC-Italic', 'AdonisC-Bold'],
					urls: ['<?=$GameAsset->baseUrl ?>/fonts.css']
				},
				loading: function () {
					var body = document.getElementsByTagName('body')[0];
					var canvas = document.createElement('canvas');

					canvas.id = 'canvas';

					body.appendChild(canvas);

					onResize();

					window.addEventListener('resize', onResize);

					kid.Games.load(<?= $content ?>, function (status) {
						if (status) {
							kid.Games.play(canvas, {})
						}
					});
				}
			});
		});
    </script>
    <style>
        html, body {
            padding: 0px;
            margin: 0px;
            height: 100%;
            overflow: hidden;
        }

        canvas {
            background-color: black;
        }
    </style>
</head>
<body>
</body>
</html>