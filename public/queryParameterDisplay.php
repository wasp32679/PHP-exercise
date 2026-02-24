<?php
$name = filter_input(INPUT_GET, "name");
$age = filter_input(INPUT_GET, "age", FILTER_VALIDATE_INT);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>URL query parameters</title>
</head>

<body>
    <?php if ($name && $age): ?>
        <h1><?= $name ?> is <?= $age ?> years old</h1>
    <?php else: ?>
        <li>missing parameter</li>
    <?php endif; ?>
</body>

</html>