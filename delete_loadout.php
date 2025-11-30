<?php
$servername = "localhost";
$username   = "root";
$password   = "4356An3?";
$dbname     = "mechmaker";

header('Content-Type: application/json');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false]);
    exit;
}

$loadout_id = isset($_POST['loadout_id']) ? (int)$_POST['loadout_id'] : 0;

if (!$loadout_id) {
    echo json_encode(['success' => false]);
    exit;
}

$conn->query("DELETE FROM WeaponsLoadout WHERE loadout_id = $loadout_id");
$ok = $conn->query("DELETE FROM loadout WHERE loadout_id = $loadout_id");

echo json_encode(['success' => $ok]);
