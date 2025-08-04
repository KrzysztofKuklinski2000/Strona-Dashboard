<?php $data = $params['data'] ?>

<div class="content-container">
	<div class="list-header">
		<h3>Kontakt - Edytuj</h3>
	</div>
	<br>
	<form action="/?dashboard=start&subpage=kontakt" method="POST" class="contact-form">
		<label>
			<span>E-mail:</span> 
			<input type="email" name="email" value="<?php echo $data['email'] ?>">
		</label>
		<label>
			<span>Telefon: </span>
			<input type="tel" name="phone" value="<?php echo $data['phone'] ?>">
		</label>
		<label>
			<span>Adres: </span>
			<input type="text" name="address" value="<?php echo $data['address'] ?>">
		</label>
		<input type="submit" value="Zapisz">
	</form>
</div>