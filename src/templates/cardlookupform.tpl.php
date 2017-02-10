<?php $this->layout('pageLayout', ['title' => 'MagicDB | Card Lookup']) ?>

<form action="cardlookup.php" method="get">
	<table>
		<tr>
			<td>Card Set (abbreviated)</td>
			<td><input type="text" name="set"></td>
		</tr>
		<tr>
			<td>Card Set Number</td>
			<td><input type="number" name="id"</td>
		</tr>
		<tr>
			<td>Card Type</td>
			<td><select name="type">
					<option value="1">Land</option>
					<option value="2">Creature</option>
					<option value="3">Artifact</option>
					<option value="4">Enchantment</option>
					<option value="5">Planeswalker</option>
					<option value="6">Instant</option>
					<option value="7">Sorcery</option>
					<option value="8">Token</option>
					<option>--------------</option>
					<option value="9">Phenomenon</option>
					<option value="10">Plane</option>
					<option value="11">Scheme</option>
					<option value="12">Tribal</option>
					<option value="13">Vanguard</option>
					<option value="14">Conspiracy</option>
				</select></td>
		</tr>
		<tr>
			<td><input type="submit" value="Lookup Card"></td>
		</tr>
	</table>
</form>
<h4>Important Notes</h4>
<ul>
	<li>Artifact Creatures should be entered as Creatures</li>
	<li>Basic Lands should be entered as Lands</li>
	<li>Not sure what set the card is in? Check <a href="setglossary.php" target="_blank">this glossary</a>!</li>
</ul>