<?php

/**
 * On this page, you need to remove a todo from the sqlite database.
 * The id of the todo to delete will be passed as a POST parameter.
 * You need to handle the deletion of the todo from the database.
 * If there is an error, display an error message.
 * If the deletion is successful, redirect the user to the list of todos.
 */

$pdo = new PDO("sqlite:" . __DIR__ . "/../database.db", null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$id = filter_input(INPUT_POST, "id");

try {
    $stmt = $pdo->prepare("delete from todos where id = ?");
    $stmt->execute([$id]);
    header("Location: displayAllTodosFromDatabase.php");
    exit();
} catch (PDOException $e) {
    $err = "Error : " . $e->getMessage();
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo deletion</title>
</head>

<body>

    <h1>Delete a todo error</h1>

    <a href="displayAllTodosFromDatabase.php">Return to todo list</a>

    <?php if ($err): ?>
        <h3><?= $err ?></h3>
    <?php endif; ?>

</body>

</html>