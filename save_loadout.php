<?php
// save_loadout.php
$servername = "localhost";
$username = "root";
$password = "mdonnelly";   // adjust if needed
$dbname = "mechmaker";     // from your createTables.sql

header('Content-Type: application/json');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB connect failed']);
    exit;
}

$mech_id = isset($_POST['mech_id']) ? (int)$_POST['mech_id'] : 0;
$name    = trim($_POST['name'] ?? '');
$weapons = $_POST['weapons'] ?? [];

if (!$mech_id || $name === '' || empty($weapons)) {
    echo json_encode(['success' => false, 'error' => 'Missing data']);
    exit;
}

// Get mech no_weapons limit
$stmt = $conn->prepare("SELECT no_weapons FROM mech WHERE mech_id = ?");
$stmt->bind_param("i", $mech_id);
$stmt->execute();
$stmt->bind_result($no_weapons);
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'error' => 'Mech not found']);
    $stmt->close();
    exit;
}
$stmt->close();

// Enforce limit
$weapons = array_map('intval', $weapons);
$weapons = array_slice(array_unique($weapons), 0, (int)$no_weapons);

// Insert loadout
$stmt = $conn->prepare("INSERT INTO loadout (mech_id, name) VALUES (?, ?)");
$stmt->bind_param("is", $mech_id, $name);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'error' => 'Insert loadout failed']);
    $stmt->close();
    exit;
}
$loadout_id = $stmt->insert_id;
$stmt->close();

// Insert weapon links
$stmt = $conn->prepare("INSERT INTO WeaponsLoadout (loadout_id, weapon_id) VALUES (?, ?)");
foreach ($weapons as $wid) {
    $stmt->bind_param("ii", $loadout_id, $wid);
    $stmt->execute();
}
$stmt->close();

echo json_encode([
    'success' => true,
    'loadout_id' => $loadout_id
]);
