<?php

if(isset($_COOKIE['__cdr']) && $_COOKIE['__cdr'] == 'true'){
	header('Location: /home.php');
}

$title = 'Главная';

ob_start();
?>

<div id="caruselMain" class="carousel carousel-dark slide" data-bs-ride="carousel">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#caruselMain" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Слайд 1"></button>
		<button type="button" data-bs-target="#caruselMain" data-bs-slide-to="1" aria-label="Слайд 2"></button>
		<button type="button" data-bs-target="#caruselMain" data-bs-slide-to="2" aria-label="Слайд 3"></button>
	</div>
	<div class="carousel-inner">
		<div class="carousel-item active">
		  	<img src="assets/images/callendar2.jpg" class="d-block w-100" alt="Преймущества CDR календаря">
		  	<div class="carousel-caption d-none d-md-block">
		    	<h5>Абсолютное преймущество перед конкурентами!</h5>
		    	<p>Ничем не отличается от обычного календаря</p>
		  	</div>
		</div>
		<div class="carousel-item">
		  	<img src="assets/images/callendar1.jpg" class="d-block w-100" alt="Дизайн CDR">
		  	<div class="carousel-caption d-none d-md-block">
		    	<h5>Самый добный интерфейс!</h5>
		    	<p>Громко сказано, но кое-чем является и правдой</p>
		  	</div>
		</div>
		<div class="carousel-item">
		  	<img src="assets/images/callendar3.jpg" class="d-block w-100" alt="Никаких будильников">
		  	<div class="carousel-caption d-none d-md-block">
		    	<h5>Больше никаких будильников на дату!</h5>
		    	<p>Самая простая и основная функция онлайн-календаря</p>
		  	</div>
		</div>
	</div>
</div>
<script>
	var myCarousel = document.querySelector('#caruselMain')
	var carousel = new bootstrap.Carousel(myCarousel, {
	  	interval: 2000,
	  	wrap: false
	})
</script>

<?php
$body = ob_get_contents();
ob_end_clean();

require_once 'render.php';
?>