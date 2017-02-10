<?php $this->layout('pageLayout', ['title' => 'MagicDB | View Cards']) ?>

<table cellpadding="3" style="text-align: center;">
	<tr align="center">
		<th>Card Name</th>
		<th>Card Mana Cost</th>
		<th>Card Typeline</th>
		<th>Card Set</th>
		<th>Card Rarity</th>
		<th>Card Text</th>
		<th>Card Image</th>
		<th>Is it a foil?</th>
	</tr>
	<?php foreach ($cards as $card): ?>
		<tr>
		<?php foreach ($card as $key => $value): ?>
			<?php if (stristr($value, 'http://')): //we have an image link?>
				<td><img src="<?=$value?>" height="150px"></td>
			<?php else: ?>
				<td><?=$value?></td>
			<?php endif?>
		<?php endforeach ?>
		</tr>
	<?php endforeach ?>
</table>