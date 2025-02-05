<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Get the request method
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        require "read.php"; // Call your read file
        break;
    case "POST":
        require "create.php"; // Call your create file
        break;
    case "PUT":
        require "update.php"; // Call your update file
        break;
    case "DELETE":
        require "delete.php"; // Call your delete file
        break;
    default:
        echo json_encode(["message" => "Invalid request"]);
        break;
}
?>
