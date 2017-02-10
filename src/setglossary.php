<?php
/**
 * Created by Zander Work on 2/9/2017 7:40 PM.
 */

require_once('Database.php');
require_once('PlatesController.php');

$sets = Database::getSets();

echo \PlatesController::renderTemplate('setglossary', ['sets' => $sets]);
?>
