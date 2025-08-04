<?php $data = $params['data']; ?>
<div class="content-container">
	<div class="list-header">
		<h3>Obozy - Edytuj</h3>
	</div>
	<br>
	<form action="/?dashboard=start&subpage=obozy" method="POST" class="camp-form ">
		<label>
			<span>Miejscowość:</span> 
			<input type="text" name="town" value="<?php echo $data['city'] ?>">
		</label>
		<label>
			<span>Nazwa Pensjonatu</span>
			<input type="text" name="guesthouse" value="<?php echo $data['guesthouse'] ?>">
		</label>
		<label>
			<span>Miejsce wyjazdu: </span>
			<input type="text" name="townStart" value="<?php echo $data['city_start'] ?> ">
		</label>
		<label>
			<span>Data wyjazdu: </span>
			<input type="date" name="dateStart" value="<?php echo $data['date_start'] ?>">
		</label>
		<label>
			<span>Data powrotu: </span>
			<input type="date" name="dateEnd" value="<?php echo $data['date_end'] ?>">
		</label>
		<label>
			<span>Godzina wyjazdu: </span>
			<input type="time" name="timeStart" value="<?php echo $data['time_start'] ?>">
		</label>
		<label>
			<span>Godzina powrotu: </span>
			<input type="time" name="timeEnd" value="<?php echo $data['time_end'] ?>">
		</label>
		<label>
			<span>Pensjonat(nazwa/adres): </span>
			<textarea name="place"><?php echo $data['place'] ?></textarea>
		</label>
		<label>
			<span>Zakwaterowanie: </span>
			<textarea name="accommodation" value=""><?php echo $data['accommodation'] ?></textarea>
		</label>
		<label>
			<span>Wyżywienie: </span>
			<textarea name="meals" value=""><?php echo $data['meals'] ?></textarea>
		</label>
		<label>
			<span>Wycieczki </span>
			<textarea name="trips" value=""><?php echo $data['trips'] ?></textarea>
		</label>
		<label>
			<span>Kadrę:</span>
			<textarea name="staff" value=""><?php echo $data['staff'] ?></textarea>
		</label>
		<label>
			<span>Transport PKP:</span>
			<textarea name="transport" value=""><?php echo $data['transport'] ?></textarea>
		</label>
		<label>
			<span>Treningi:</span>
			<textarea name="training" value=""><?php echo $data['training'] ?></textarea>
		</label>
		<label>
			<span>Ubezpieczenie:</span>
			<textarea name="insurance" value=""><?php echo $data['insurance'] ?>	</textarea>
		</label>
		<label>
			<span>Koszt:</span>
			<input type="number" name="cost" value="<?php echo $data['cost'] ?>">
		</label>
		<label>
			<span>Zaliczka:</span>
			<input type="number" name="advancePayment" value="<?php echo $data['advancePayment'] ?>">
		</label>
		<label>
			<span>Data zaliczki</span>
			<input type="date" name="advanceDate" value="<?php echo $data['advanceDate'] ?>">
		</label>
		<input type="submit" value="Zapisz">
	</form>
</div>