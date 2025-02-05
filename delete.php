<?php 
include 'db.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $conn->query("DELETE FROM posts WHERE id=$id");
    header("location: posts.php");
}
?>