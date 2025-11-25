<?php
// DB connection
$servername = "localhost";
$username   = "root";
$password   = "4356An3?";
$dbname     = "mechmaker";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}


// Get all loadouts + mech info

$loadouts = [];

$sqlLoadouts = "
    SELECT
        l.loadout_id,
        l.name        AS loadout_name,
        m.mech_id,
        m.name        AS mech_name,
        m.tonnage,
        m.armor,
        m.speed
    FROM loadout l
    LEFT JOIN mech m ON l.mech_id = m.mech_id
    ORDER BY l.loadout_id
";

if ($res = $conn->query($sqlLoadouts)) {
    while ($row = $res->fetch_assoc()) {
        $loadouts[$row['loadout_id']] = [
            'loadout_id'  => (int)$row['loadout_id'],
            'name'        => $row['loadout_name'],
            'mech_id'     => $row['mech_id'],
            'mech_name'   => $row['mech_name'],
            'tonnage'     => $row['tonnage'],
            'armor'       => $row['armor'],
            'speed'       => $row['speed'],
            'weapons'     => []  // will fill in next
        ];
    }
}

// If there are no loadouts, no need to query weapons
$weaponsByLoadout = [];
if (!empty($loadouts)) {
    
    // Get all weapons per loadout

    $sqlWeapons = "
        SELECT
            wl.loadout_id,
            w.weapon_id,
            w.name        AS weapon_name,
            w.type,
            w.short_damage,
            w.medium_damage,
            w.long_damage
        FROM WeaponsLoadout wl
        JOIN weapon w ON wl.weapon_id = w.weapon_id
        ORDER BY wl.loadout_id, w.name
    ";

    if ($resW = $conn->query($sqlWeapons)) {
        while ($row = $resW->fetch_assoc()) {
            $lid = (int)$row['loadout_id'];
            if (!isset($loadouts[$lid])) {
                continue;
            }
            $loadouts[$lid]['weapons'][] = [
                'weapon_id'     => (int)$row['weapon_id'],
                'name'          => $row['weapon_name'],
                'type'          => $row['type'],
                'short_damage'  => $row['short_damage'],
                'medium_damage' => $row['medium_damage'],
                'long_damage'   => $row['long_damage'],
            ];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MechMaker – Loadouts</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        header {
            background: #222;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header h1 {
            margin: 0;
            font-size: 22px;
        }

        .back-link {
            color: #ddd;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .page-container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 0 15px 40px;
        }

        .page-title {
            margin: 0 0 10px;
            font-size: 24px;
        }

        .page-subtitle {
            margin: 0 0 20px;
            color: #555;
            font-size: 14px;
        }

        .loadouts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .loadout-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px 15px 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .loadout-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
        }

        .loadout-name {
            font-size: 18px;
            font-weight: bold;
        }

        .loadout-subtitle {
            font-size: 12px;
            color: #666;
        }

        .stats-row {
            display: flex;
            gap: 10px;
            font-size: 12px;
            color: #444;
        }

        .stat-pill {
            background: #f1f1f1;
            border-radius: 999px;
            padding: 3px 10px;
        }

        .weapons {
            font-size: 13px;
        }

        .weapons span.label {
            font-weight: bold;
        }

        .weapon-entry {
            margin-top: 3px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<header>
    <h1>MechMaker – Loadouts</h1>
    <a class="back-link" href="index.php">&larr; Back to MechMaker</a>
</header>

<div class="page-container">
    <h2 class="page-title">Available Loadouts</h2>
    <p class="page-subtitle">
        These loadouts are pulled from your <code>loadout</code>, <code>mech</code>, and <code>weapon</code> tables.
    </p>

    <?php if (empty($loadouts)): ?>
        <p>No loadouts found.</p>
    <?php else: ?>
        <div class="loadouts-grid">
            <?php foreach ($loadouts as $loadout): ?>
                <div class="loadout-card">
                    <div class="loadout-header">
                        <div>
                            <div class="loadout-name">
                                <?php echo htmlspecialchars($loadout['name']); ?>
                            </div>
                            <div class="loadout-subtitle">
                                <?php if (!empty($loadout['mech_name'])): ?>
                                    Mech: <?php echo htmlspecialchars($loadout['mech_name']); ?>
                                <?php else: ?>
                                    Mech: (none linked)
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="stats-row">
                        <?php if (!is_null($loadout['armor'])): ?>
                            <div class="stat-pill">
                                Armor: <?php echo (int)$loadout['armor']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!is_null($loadout['speed'])): ?>
                            <div class="stat-pill">
                                Speed: <?php echo (int)$loadout['speed']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!is_null($loadout['tonnage'])): ?>
                            <div class="stat-pill">
                                Tonnage: <?php echo (int)$loadout['tonnage']; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="weapons">
                        <span class="label">Weapons:</span>
                        <?php if (empty($loadout['weapons'])): ?>
                            <div class="weapon-entry">
                                (No weapons assigned)
                            </div>
                        <?php else: ?>
                            <?php foreach ($loadout['weapons'] as $w): ?>
                                <div class="weapon-entry">
                                    <?php echo htmlspecialchars($w['name']); ?>
                                    (<?php echo htmlspecialchars($w['type']); ?>) –
                                    Short: <?php echo (int)$w['short_damage']; ?>,
                                    Med: <?php echo (int)$w['medium_damage']; ?>,
                                    Long: <?php echo (int)$w['long_damage']; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
