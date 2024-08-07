<?php

/*******w******** 
    Name: Samuel Musafiri
    Date: 2024-06-21
    Description: Post Page
****************/

require('connect.php');
// Check if the request method is POST, meaning the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the POST data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $timestamp = date('Y-m-d');// Get the current date for the timestamp

    // Prepare the SQL statement to insert a new post with placeholders for safety
    $stmt = $db->prepare("INSERT INTO posts (title, content, timestamp) VALUES (:title, :content, :timestamp)");

     // Bind the form data to the placeholders in the SQL statement
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':timestamp', $timestamp);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        // If the insertion was successful, redirect to the index page
        header("Location: index.php");
        exit();
    } else {
        // If the insertion failed, set the error message
        $error = "Failed to add new post.";
    }
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>New Post</title>
</head>
<body>
    <header>
        <h1>Create a New Post</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="post.php">New Post</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
            <label for="content">Content</label>
            <textarea id="content" name="content" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section> 
</body>
</html>
