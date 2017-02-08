<?php
/**
 * Created by Zander Work on 2/6/2017 8:29 PM.
 */

require_once('Database.php');
require_once('PlatesController.php');

echo \PlatesController::renderTemplate('home', ['name' => 'zander']);
?>
