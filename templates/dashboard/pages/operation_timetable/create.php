<br>
<h3>Nowy Dzień Treningowy</h3>
<br>
<form action="?dashboard=start&subpage=grafik&operation=create" method="POST" class="timetable-create-form">
	<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
	<label>
		<span>Dzień: </span>
		<select name="day">
			<option value="PON">Poniedziałek</option>
			<option value="WT">Wtorek</option>
			<option value="ŚR">Środa</option>
			<option value="CZW">Czwartek</option>
			<option value="PT">Piątek</option>
			<option value="SOB">Sobota</option>
			<option value="NIEDZ">Niedziela</option>
		</select>
	</label>
	<label>
		<span>Miasto: </span>
		<input type="text" name="city" maxlength="30" placeholder="Reda">
	</label>
	<label>
		<span>Grupa</span>
		<select name="group">
			<option value="Zaawansowana">Zaawansowana</option>
			<option value="Wszyscy">Wszyscy</option>
			<option value="Poaczątkujący">Początkujący</option>
			<option value="Dzieci">Dzieci</option>
			<option value="Dzieci początkujące">Dzieci początkujące</option>
			<option value="Kadra">Kadra</option>
		</select>
	</label>
	<label>
		<span>Opis miejsca: </span>
		<input type="text" name="place" maxlength="100" placeholder="np: sala gimnastyczna/salka pod basenem">
	</label>
	<label>
		<span>Start:</span>
		<input type="time" name="startTime">
	</label>
	<label>
		<span>Koniec:</span>
		<input type="time" name="endTime">
	</label>
	<input type="submit" value="Stwórz">
</form>