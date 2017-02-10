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
				</select></td>
		</tr>
		<tr>
			<td><input type="submit" value="Lookup Card"></td>
		</tr>
	</table>
</form>
<br>
<br>
<h4>Important Notes</h4>
<ul>
	<li>Artifact Creatures should be entered as Creatures</li>
	<li>Basic Lands and Lands should be entered as Lands</li>
</ul>