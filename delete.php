<?php
require('connect.php');
require('authenticate.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the post ID from the GET request
    $id = $_GET['id'];

    // Prepare the SQL statement to delete the post by ID
    $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $id);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        // If the delete was successful, redirect to the index page
        header("Location: index.php");
        exit();
    } else {
        // If the delete failed, set the error message
        $error = "Failed to delete post.";
        echo htmlspecialchars($error);
    }
} else {
    // If request method is not GET, display an error
    die("Invalid request.");
}
?>

