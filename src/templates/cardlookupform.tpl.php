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
			<td><input type="submit" value="Lookup Card"></td>
		</tr>
	</table>
</form>