<?php
require('connect.php');
require('authenticate.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the POST data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Bind the form data to the placeholders in the SQL statement
    $stmt = $db->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':id', $id);
    
    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        // If the update was successful, redirect to the index page
        header("Location: index.php");
        exit();
    } else {
        // if the update failed, set the error message
        $error = "Failed to update post.";
    }
} else {
    // if request method is not POST, means form is being loaded for the first time
    $id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$post) {
        die("Post not found.");
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
    <title>Edit this Post!</title>
</head>
<body>
    <header>
        <h1>Edit Post</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="new_post.php">New Post</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            <label for="content">Content</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            <button type="submit">Update</button>
        </form>
    </section>
</body>
</html>
