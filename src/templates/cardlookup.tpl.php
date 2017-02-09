<?php $this->layout('pageLayout', ['title' => 'MagicDB | Card Lookup']) ?>

<img src="<?=$image?>"><br>

<table>
	<?php foreach($cardInfo as $key => $value): ?>
		<tr>
			<td><?=$key?></td>
			<td><?=$value?></td>
		</tr>
	<?php endforeach ?>
</table>