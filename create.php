<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $read_more_link = $_POST['read_more_link'] ?? null;

    // Handle file upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Use a prepared statement to prevent SQL errors
        $stmt = $conn->prepare("INSERT INTO posts (title, content, read_more_link, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $content, $read_more_link, $image);

        if ($stmt->execute()) {
            header("Location: posts.php?success=Post created successfully!");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading image.";
    }
}

$conn->close();
?>
<head>
    <link rel="stylesheet" href="style.css">
</head>

<form action="create.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Post Title" required><br>
    <textarea name="content" placeholder="Post Content" required></textarea><br>
    <input type="text" name="read_more_link" placeholder="External Read More Link"><br>
    <input type="file" name="image" required><br>
    <button type="submit">Create Post</button>
</form>

