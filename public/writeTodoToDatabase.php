<?php

/**
 * On this page, you will create a simple form that allows user to create todos (with a name and a date).
 * The form should be submitted to this PHP page.
 * Then get the inputs from the post request with `filter_input`.
 * Then, the PHP code should verify the user inputs (minimum length, valid date...)
 * If the user input is valid, insert the new todo information in the sqlite database
 * table `todos` columns `title` and `due_date`. Then redirect the user to the list of todos.
 * If the user input is invalid, display an error to the user
 */

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
$date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
$errors = [];

$pdo = new PDO("sqlite:" . __DIR__ . "/../database.db");
if ($name !== false && $date !== false) {
    $d = DateTime::createFromFormat("Y-m-d", $date);

    if (trim($name) === "") {
        $errors[] = "Name can not be empty";
    } elseif ($d === false) {
        $errors[] = "Invalid date";
    } elseif (trim($name) !== "" && $d !== false) {
        $stmt = $pdo->prepare("insert into todos (title, due_date) values (?, ?)");
        $stmt->execute([$name, $date]);
        header("Location: displayAllTodosFromDatabase.php");
        exit();
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a new todo</title>
</head>

<body>

    <h1>
        Create a new todo
    </h1>
    <form action="writeTodoToDatabase.php" method="POST">
        <label for="name">Name :</label>
        <input type="text" id="name" name="name">
        <label for="date">Date :</label>
        <input type="date" id="date" name="date">
        <button type="submit">Submit</button>
    </form>
    <?php if (!empty($errors)): ?>
        <h2><?= $errors[0] ?></h2>
    <?php endif; ?>

</body>

</html>