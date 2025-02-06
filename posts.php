<?php 
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
</head>

<style>
    .row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f4f7f6;
    padding: 10px 20px;
    border-bottom: 1px solid #ddd;
}

.add-post-container {
    font-size: 16px;
}

.add-post-btn {
    text-decoration: none;
    background: #5cb85c;
    color: white;
    padding: 10px 15px;
    border-radius: 4px;
    font-size: 14px;
}

.add-post-btn:hover {
    background: #4cae4c;
}

</style>
<body>

    <div style="padding: 20px;">
        <h1 class="page-title">Recent Blog Posts</h1>

        <!-- Add New Post Button -->
        <div class="row">
            <div class="add-post-container">
                <a href="create.php" class="add-post-btn">➕ Add New Post</a>
            </div>
            <div>
                <a href="logout.php" class="add-post-btn">Logout</a>
            </div>
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
