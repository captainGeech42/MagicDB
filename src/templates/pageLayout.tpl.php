<html>
<head>
	<title><?=$this->e($title)?></title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>

<?php if (strcmp($this->e($title), 'MagicDB | Home') !== 0): ?>
	<a href="index.php">Return Home</a><br><br>
<?php endif ?>

<?=$this->section('content')?>

</body>
</html>