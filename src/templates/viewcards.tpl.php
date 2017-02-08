<?php $this->layout('pageLayout', ['title' => 'MagicDB | View Cards']) ?>

<table cellpadding="3">
	<tr align="center">
		<th>Card Name</th>
		<th>Card Mana Cost</th>
		<th>Card Rarity</th>
		<th>Card Text</th>
	</tr>
	<?php foreach ($cards as $card): ?>
		<tr align="center">
			<td><?=$card['name']?></td>
			<td><?=$card['mana']?></td>
			<td><?=$card['rarity']?></td>
			<td><?=$card['text']?></td>
		</tr>
	<?php endforeach ?>
</table>