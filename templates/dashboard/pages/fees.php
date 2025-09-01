<?php
$data = $params['data'];
?>
<div class="content-container">
	<div class="list-header">
		<h3>Opłaty - Edytuj</h3>
	</div>
	<br>
	<form action="/?dashboard=start&subpage=oplaty" method="POST" class="price-form ">
		<input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?? '' ?>">
		<label>
			<span>Składka Ulgowa (jedna osoba):</span>
			<input type="number" name="n1" value="<?php echo $data['reduced_contribution_1_month'] ?>">
		</label>
		<label>
			<span>Składka Ulgowa (dwie osoby): </span>
			<input type="number" name="n2" value="<?php echo $data['reduced_contribution_2_month'] ?>">
		</label>
		<label>
			<span>Składka rodzina: </span>
			<input type="number" name="n3" value="<?php echo $data['family_contribution_month'] ?>">
		</label>
		<label>
			<span>Składka Normalna: </span>
			<input type="number" name="n4" value="<?php echo $data['contribution'] ?>">
		</label>
		<label>
			<span>Wpisowe: </span>
			<input type="number" name="n5" value="<?php echo $data['entry_fee'] ?>">
		</label>
		<label>
			<span>Składka Ulgowa (jedna osoba/rok): </span>
			<input type="number" name="n6" value="<?php echo $data['reduced_contribution_1_year'] ?>">
		</label>
		<label>
			<span>Składka Ulgowa (dwie osoby/rok): </span>
			<input type="number" name="n7" value="<?php echo $data['reduced_contribution_2_year'] ?>">
		</label>
		<label>
			<span>Składka Rodzinna (za rok):</span>
			<input type="number" name="n8" value="<?php echo $data['family_contribution_year'] ?>">
		</label>
		<label>
			<span>Składka Ulgowa Wakacje (np: 70zł, 110zł, 160zł):</span>
			<input type="text" name="n9" value="<?php echo $data['reduced_contribution_holidays'] ?>">
		</label>
		<label>
			<span>Informacje:</span>
			<textarea name="n10"><?php echo $data['extra_information'] ?></textarea>
		</label>
		<input type="submit" value="Zapisz">
	</form>
</div>