<?php $this->layout('pageLayout', ['title' => 'MagicDB | Set Glossary']) ?>

<div id="sets">
<table cellspacing="5" style="text-align: center;">
	<tr>
		<th>Icon</th>
		<th>Abbreviation</th>
		<th>Name</th>
	</tr>
	<?php foreach ($sets as $set): ?>
		<tr>
			<td><img src="img/set_icon/<?=$set['abbreviation']?>.png"></td>
			<td><?=$set['abbreviation']?></td>
			<td><?=$set['name']?></td>
		</tr>
	<?php endforeach ?>
</table>
</div>