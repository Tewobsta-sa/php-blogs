<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM posts WHERE id = $id");
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $read_more_link = $_POST['read_more_link'] ?? null;

    // Handle image upload (if a new image is uploaded)
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Use a prepared statement to prevent SQL errors
            $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, read_more_link=?, image=? WHERE id=?");
            $stmt->bind_param("ssssi", $title, $content, $read_more_link, $image, $id);
        }
    } else {
        // Update post without changing image
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, read_more_link=? WHERE id=?");
        $stmt->bind_param("sssi", $title, $content, $read_more_link, $id);
    }

    if ($stmt->execute()) {
        header("Location: posts.php?success=Post updated successfully!");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= $row['title'] ?>" required><br>
    <textarea name="content" required><?= $row['content'] ?></textarea><br>
    <input type="text" name="read_more_link" value="<?= $row['read_more_link'] ?>" placeholder="External Read More Link (optional)"><br>
    
    <label>Current Image:</label><br>
    <img src="uploads/<?= $row['image'] ?>" width="100"><br>
    
    <label>Change Image (optional):</label><br>
    <input type="file" name="image"><br>

    <button type="submit">Update Post</button>
</form>
