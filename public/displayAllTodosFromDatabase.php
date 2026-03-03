<?php

/**
 * Get the todos from the sqlite database, and display them in a list.
 * You need to add a sort query parameter to the page to order by date or name.
 * If the query parameter is not set, the todos should be displayed in the order they were added.
 * If the request to the database fails, display an error message.
 * If the user wants to delete a todo, a form that sends a POST request to the deleteTodoFromDatabase.php page should be displayed on each todo elements.
 * The sort option selected must be remembered after the form submission (use a query parameter).
 * The todo title and date should be displayed in a list (date in american format).
 */

$pdo = new PDO("sqlite:" . __DIR__ . "/../database.db", null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$sort = filter_input(INPUT_GET, "sort");

try {
    if ($sort === "name") {
        $stmt = $pdo->prepare("select * from todos order by title");
    } elseif ($sort === "date") {
        $stmt = $pdo->prepare("select * from todos order by due_date");
    } else {
        $stmt = $pdo->prepare("select * from todos");
    }
    $stmt->execute();
    $todos = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of todos</title>
</head>

<body>

    <h1>
        All todos
    </h1>

    <a href="writeTodoToDatabase.php">Ajouter une nouvelle todo</a>
    <a href="?sort=name">Sort by name</a>
    <a href="?sort=date">Sort by date</a>
    <a href="displayAllTodosFromDatabase.php">Reset</a>

    <ul>
        <?php foreach ($todos as $t): ?>
            <li>
                <div>
                    <p><?= htmlspecialchars($t["title"]) ?></p>
                    <p><?= $t["due_date"] ?></p>
                    <form action="deleteTodoFromDatabase.php" method="POST">
                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>

            </li>
        <?php endforeach; ?>
    </ul>

</body>

</html>