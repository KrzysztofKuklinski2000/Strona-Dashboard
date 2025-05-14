<?php
$content = $params['content'];
?>

<div class="respons-container padding-top">
	<?php
	$text = 'Klub Karate Kyoskushin <br/> i Sportów Walki';
	require('templates/components/post_header.php');
	?>

	<br>
	<div class="contact-information">
		<div class="flex-item-center">
			<i class="fa-solid fa-map-pin"></i>
			<p><?php echo $content['address']; ?></p>
		</div>
		<div class="flex-item-center">
			<i class="fa-solid fa-mobile-screen-button"></i>
			<p><?php echo $content['phone']; ?></p>
		</div>
		<div class="flex-item-center">
			<i class="fa-regular fa-envelope"></i>
			<p><?php echo $content['email']; ?></p>
		</div>
	</div>
	<br><br>
	<?php
	$text = 'Jak Dojechać';
	require('templates/components/post_header.php');
	?>
	<br>
</div>
<iframe
	src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2310.6992536077355!2d18.23527337586969!3d54.60929057948394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46fdba28b18c18dd%3A0x5cbaf193380fe60d!2sNanicka%2022%2C%2084-200%20Wejherowo!5e0!3m2!1spl!2spl!4v1713019237782!5m2!1spl!2spl" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>