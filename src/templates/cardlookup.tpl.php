<?php $this->layout('pageLayout', ['title' => 'MagicDB | Card Lookup']) ?>

<img src="<?=$image?>"><br><br>

<table cellspacing="5" border="4">
	<?php foreach($cardInfo as $key => $value): ?>
		<tr>
			<td><?=$key?></td>
			<td><?=$value?></td>
		</tr>
	<?php endforeach ?>
</table>