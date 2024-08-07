<?php

/*******w******** 
    Name: Samuel MUsafiri
    Date: 2024-06-21
    Description: Home Page
****************/

require('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blog!</title>
</head>
<body>
    <header>
        <h1>Welcome to my Blog!</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="post.php">New Post</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <?php
        try {
            // Fetch posts from the database, ordered by timestamp in descending order
            $stmt = $db->query('SELECT * FROM posts ORDER BY timestamp DESC');
            // Loop through each post, displays it
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<article>';
                // Display the post title
                echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                // Display the post content
                echo '<p>' . htmlspecialchars($row['content']) . '</p>';

                // Format the timestamp into a long format
                $dateTime = new DateTime($row['timestamp']);
                $formattedDate = $dateTime->format('l, F j, Y \a\t g:i A');

                // Display the formatted post date
                echo '<p><small>Posted on ' . htmlspecialchars($formattedDate) . '</small></p>';

                // Display the edit link for the post
                echo '<a href="edit.php?id=' . htmlspecialchars($row['id']) . '">Edit</a> | ';
                echo '<a href="delete.php?id=' . htmlspecialchars($row['id']) . '" onclick="return confirm(\'Are you sure you want to delete this post?\');">Delete</a>';
                echo '</article>';
            }
        } catch (PDOException $e) {
            // Display an error message if there is a database error
            echo 'Error: ' . $e->getMessage();
        }
        ?>
    </section>
</body>
</html>
