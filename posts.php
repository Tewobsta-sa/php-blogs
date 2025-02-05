<?php 
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
</head>
<body>

    <div style="padding: 20px;">
        <h1 class="page-title">Recent Blog Posts</h1>

        <!-- Add New Post Button -->
        <div class="add-post-container">
            <a href="create.php" class="add-post-btn">➕ Add New Post</a>
        </div>

        <table class="posts-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Read More Link</th>
            <th>Posted Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= substr($row['title'], 0, 25) . (strlen($row['title']) > 50 ? '...' : '') ?></td>
                    <td><?= substr($row['content'], 0, 50) . (strlen($row['content']) > 100 ? '...' : '') ?></td>
                    <td>
                        <?php if (!empty($row['read_more_link'])): ?>
                            <a href="<?= $row['read_more_link'] ?>" target="_blank" 
                            style="color: black; text-decoration: none;">
                                <?= substr($row['read_more_link'], 0, 50) . (strlen($row['read_more_link']) > 50 ? '...' : '') ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="update.php?id=<?= $row['id'] ?>" class="edit-btn"> Edit</a> | 
                        <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this post?')"> Delete</a>
                    </td>
                </tr>
        <?php endwhile; ?>
    </tbody>
</table>





</body>
</html>
