<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\CityAsset;
$CityAsset = new CityAsset();

$producer = $this->params['producer'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?= Html::encode($this->title) ?></title>
		<link rel="icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet/less" type="text/less" href="<?=$CityAsset->baseUrl ?>/css/style.less" />
		<link rel="stylesheet/less" type="text/less" href="<?=$CityAsset->baseUrl ?>/css/locations.less" />
		<script src="<?=$CityAsset->baseUrl ?>/js/js_v2.7.2_less.min.js"></script>
		<script type="text/javascript" src="<?=$CityAsset->baseUrl ?>/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="<?=$CityAsset->baseUrl ?>/js/all_pages.js"></script>

		<script type="text/javascript">
		    window.onload = function() {
		        if (is_touch_device()) {
		            $("head").append('<link rel="stylesheet" type="text/css" href="<?=$CityAsset->baseUrl ?>/css/touches.css" />');
		        }
		    }
		</script>
	</head>
	<body id="filmstudio">

		<section id="wrapper">

			<div id="stop_movie">
				<img src="<?=$CityAsset->baseUrl ?>/img/stop-yellow2.png" width="90" />
			</div>

			<video onloadstart="this.volume=0.3" autoPlay class="bgvideo fade" id="bgvideo">
			   <source src="<?=$CityAsset->baseUrl ?>/media/filmstudio.mp4" />
			   <source src="<?=$CityAsset->baseUrl ?>media/filmstudio.webm" type='video/webm; codecs="vp8, vorbis"' />
			   <source src="<?=$CityAsset->baseUrl ?>/media/filmstudio.ogv" type='video/ogg; codecs="theora, vorbis"' />
			</video>

			<section id="wrap_site">
				<div id="header" style="background: url('<?=$CityAsset->baseUrl ?>/img/ribbon4.png') no-repeat scroll -9px 125px transparent;">
					<a href="#" id="logo">
						<img src="<?=$CityAsset->baseUrl ?>/img/logo1.png" />
					</a>
				</div>
				
				<div id="wrap_content">
					
					<div id="left_block">
						
						<div id="board2">
							<ul>
								<li>Наши вакансии</li>
								<ol>Продюсер</ol>
								<?php if($producer){ ?>
								<ol>
									<a href="<?= Url::to(['city/settle','name' => 'producer']);?>">Устроиться</a>
								</ol>
								<?php } ?>
							</ul>

						</div>

						<nav id="buttons">
							<ul>
								<li>
									<a href="<?= Url::to(['game/producer/']);?>">Служебный вход</a>
								</li>
								<li>
									<a href="/">Карта</a>
								</li>
							</ul>
						</nav>

					</div>

				</div>


			</section>

		</section>

	</body>
</html>
