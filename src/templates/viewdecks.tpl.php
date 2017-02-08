<?php $this->layout('pageLayout', ['title' => 'MagicDB | View Decks']) ?>

<table cellpadding="3">
	<tr align="center">
		<th>Format</th>
		<th>Name</th>
		<th>Card IDs</th>
	</tr>
	<?php foreach ($decks as $deck): ?>
		<tr align="center">
			<td><?=$deck['format']?></td>
			<td><?=$deck['name']?></td>
			<td><?=$deck['cards']?></td>
		</tr>
	<?php endforeach ?>
</table>
