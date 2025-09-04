<?php 
	$data = $params['data']; 
?>
<div class="content-container">
	<div class="list-header">
		<h3>Obozy - Edytuj</h3>
	</div>
	<br>
	<form action="/?dashboard=start&subpage=obozy" method="POST" class="camp-form ">
		<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
		<label>
			<span>Miejscowość:</span> 
			<input type="text" name="town" value="<?php echo $data['city'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['town'] ?? ""  ?></p>
		<label>
			<span>Nazwa Pensjonatu</span>
			<input type="text" name="guesthouse" value="<?php echo $data['guesthouse'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['guesthouse'] ?? ""  ?></p>
		<label>
			<span>Miejsce wyjazdu: </span>
			<input type="text" name="townStart" value="<?php echo $data['city_start'] ?> ">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['townStart'] ?? ""  ?></p>
		<label>
			<span>Data wyjazdu: </span>
			<input type="date" name="dateStart" value="<?php echo $data['date_start'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['dateStart'] ?? ""  ?></p>
		<label>
			<span>Data powrotu: </span>
			<input type="date" name="dateEnd" value="<?php echo $data['date_end'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['dateEnd'] ?? ""  ?></p>
		<label>
			<span>Godzina wyjazdu: </span>
			<input type="time" name="timeStart" value="<?php echo $data['time_start'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['timeStart'] ?? ""  ?></p>
		<label>
			<span>Godzina powrotu: </span>
			<input type="time" name="timeEnd" value="<?php echo $data['time_end'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['timeEnd'] ?? ""  ?></p>
		<label>
			<span>Pensjonat(nazwa/adres): </span>
			<textarea name="place"><?php echo $data['place'] ?></textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['place'] ?? ""  ?></p>
		<label>
			<span>Zakwaterowanie: </span>
			<textarea name="accommodation" value=""><?php echo $data['accommodation'] ?></textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['accommodation'] ?? ""  ?></p>
		<label>
			<span>Wyżywienie: </span>
			<textarea name="meals" value=""><?php echo $data['meals'] ?></textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['meals'] ?? ""  ?></p>
		<label>
			<span>Wycieczki </span>
			<textarea name="trips" value=""><?php echo $data['trips'] ?></textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['trips'] ?? ""  ?></p>
		<label>
			<span>Kadrę:</span>
			<textarea name="staff" value=""><?php echo $data['staff'] ?></textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['staff'] ?? ""  ?></p>
		<label>
			<span>Transport PKP:</span>
			<textarea name="transport" value=""><?php echo $data['transport'] ?></textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['transport'] ?? ""  ?></p>
		<label>
			<span>Treningi:</span>
			<textarea name="training" value=""><?php echo $data['training'] ?></textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['training'] ?? ""  ?></p>
		<label>
			<span>Ubezpieczenie:</span>
			<textarea name="insurance" value=""><?php echo $data['insurance'] ?>	</textarea>
		</label>
		<p class="validation-error"><?= $params['flash']['message']['insurance'] ?? ""  ?></p>
		<label>
			<span>Koszt:</span>
			<input type="number" name="cost" value="<?php echo $data['cost'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['cost'] ?? ""  ?></p>
		<label>
			<span>Zaliczka:</span>
			<input type="number" name="advancePayment" value="<?php echo $data['advancePayment'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['advancePayment'] ?? ""  ?></p>
		<label>
			<span>Data zaliczki</span>
			<input type="date" name="advanceDate" value="<?php echo $data['advanceDate'] ?>">
		</label>
		<p class="validation-error"><?= $params['flash']['message']['advanceDate'] ?? ""  ?></p>
		<input type="submit" value="Zapisz">
	</form>
</div>