<?php $data = $params['data'] ?>

<div class="content-container">
	<div class="list-header">
		<h3>Kontakt - Edytuj</h3>
	</div>
	<br>
	<form action="/?dashboard=start&subpage=kontakt" method="POST" class="contact-form">
	<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
		<label>
			<span>E-mail:</span> 
			<input type="email" name="email" value="<?php echo $data['email'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['email'] ?? ""  ?></p>
		<label>
			<span>Telefon: </span>
			<input type="tel" name="phone" value="<?php echo $data['phone'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['phone'] ?? ""  ?></p>
		<label>
			<span>Adres: </span>
			<input type="text" name="address" value="<?php echo $data['address'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['address'] ?? ""  ?></p>
		<input type="submit" value="Zapisz">
	</form>
</div>