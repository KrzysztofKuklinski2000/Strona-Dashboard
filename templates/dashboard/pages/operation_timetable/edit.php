<?php $data['day'] = trim($data['day']) ?>
<br>
<h3>Edytuj </h3>
<br>
<form action="?dashboard=start&subpage=grafik&operation=edit" method="POST" class="timetable-create-form">
	<input type="hidden" name="id" value = "<?php echo $data['id'] ?>">
	<label>
		<span>Dzień: </span> 
		<select name="day">
			<option <?php echo $data['day'] === "PON"   ? 'selected' : '' ?> value="PON"> Poniedziałek </option>
			<option <?php echo $data['day'] === "WT"    ? 'selected' : '' ?> value="WT"> Wtorek       </option>
			<option <?php echo $data['day'] === 'ŚR'    ? 'selected' : '' ?> value="ŚR"> Środa		 </option>
			<option <?php echo $data['day'] === 'CZW'   ? 'selected' : '' ?> value="CZW"> Czwartek 	 </option>
			<option <?php echo $data['day'] === 'PT'    ? 'selected' : '' ?> value="PT"> Piątek 	 	 </option>
			<option <?php echo $data['day'] === 'SOB'   ? 'selected' : '' ?> value="SOB"> Sobota 		 </option>
			<option <?php echo $data['day'] === 'NIEDZ' ? 'selected' : '' ?> value="NIEDZ"> Niedziela 	 </option>
		</select>
	</label>
	<label>
		<span>Miasto: </span>
		<input type="text" name="city" maxlength="30" value="<?php echo $data['city'] ?>" >
	</label>
	<label>
		<span>Grupa</span>
		<select name="group">
			<option <?php echo $data['advancement_group'] == "Zaawansowana" ? 'selected' : '' ?>    value="Zaawansowana"> Zaawansowana </option>
			<option <?php echo $data['advancement_group'] == "Wszyscy"      ? 'selected' : '' ?>    value="Wszyscy">      Wszyscy </option>
			<option <?php echo $data['advancement_group'] == "Początkująca" ? 'selected' : '' ?>    value="Początkująca"> Początkująca </option>
			<option <?php echo $data['advancement_group'] == "Dzieci"       ? 'selected' : '' ?>    value="Dzieci">       Dzieci </option>
			<option <?php echo $data['advancement_group'] == "Kadra"        ? 'selected' : '' ?>    value="Kadra">        Kadra </option>
			<option <?php echo $data['advancement_group'] == "Początkująca dzieci"?'selected' :''?> value="Początkująca dzieci">Początkująca dzieci</option>
		</select>
	</label>
	<label>
		<span>Opis miejsca: </span>
		<input type="text" name="place" maxlength="100" value="<?php echo $data['place'] ?>">
	</label>
	<label>
		<span>Start:</span>
		<input type="time" name="startTime" value="<?php echo $data['start'] ?>">
	</label>
	<label>
		<span>Koniec:</span>
		<input type="time" name="endTime" value="<?php echo $data['end'] ?>">
	</label>
	<input type="submit" value="Zapisz">
</form>