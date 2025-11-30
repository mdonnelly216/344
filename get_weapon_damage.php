<?php
$servername = "localhost";
$username = "root";
$password = "4356An3?";
$dbname = "mechmaker";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "DB connection failed"]));
}

$name = $_GET['name'] ?? '';
if (!$name) {
    echo json_encode(["success" => false, "error" => "Missing name"]);
    exit;
}

$stmt = $conn->prepare("
    SELECT short_damage, medium_damage, long_damage 
    FROM weapon 
    WHERE name = ?
");
$stmt->bind_param("s", $name);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if (!$res) {
    echo json_encode(["success" => false, "error" => "Weapon not found"]);
    exit;
}

echo json_encode([
    "success" => true,
    "damage" => $res
]);

$conn->close();
