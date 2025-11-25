<?php

$servername = "localhost";
$username = "root";
$password = "mdonnelly"; 
$dbname = "mechmaker";

header('Content-Type: application/json');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB connect failed']);
    exit;
}

$loadout_id = isset($_GET['loadout_id']) ? (int)$_GET['loadout_id'] : 0;
if (!$loadout_id) {
    echo json_encode(['success' => false, 'error' => 'Missing loadout id']);
    exit;
}

//query
$stmt = $conn->prepare("
    SELECT l.loadout_id, l.name,
           m.mech_id, m.name AS mech_name, m.no_weapons
    FROM loadout l
    JOIN mech m ON l.mech_id = m.mech_id
    WHERE l.loadout_id = ?
");
$stmt->bind_param("i", $loadout_id);
$stmt->execute();
$result = $stmt->get_result();
$header = $result->fetch_assoc();
$stmt->close();

if (!$header) {
    echo json_encode(['success' => false, 'error' => 'Loadout not found']);
    exit;
}

//Weapons
$stmt = $conn->prepare("
    SELECT w.weapon_id, w.name
    FROM WeaponsLoadout wl
    JOIN weapon w ON wl.weapon_id = w.weapon_id
    WHERE wl.loadout_id = ?
");
$stmt->bind_param("i", $loadout_id);
$stmt->execute();
$wRes = $stmt->get_result();
$weapons = [];
while ($row = $wRes->fetch_assoc()) {
    $weapons[] = $row;
}
$stmt->close();

echo json_encode([
    'success' => true,
    'loadout_id' => (int)$header['loadout_id'],
    'name' => $header['name'],
    'mech' => [
        'mech_id'    => (int)$header['mech_id'],
        'name'       => $header['mech_name'],
        'no_weapons' => (int)$header['no_weapons']
    ],
    'weapons' => $weapons
]);
