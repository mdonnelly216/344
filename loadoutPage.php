<?php
// =============================
// Sample mech loadouts
// (You can later pull these from a database instead.)
// =============================
$loadouts = [
    [
        'name' => 'Scout Runner',
        'class' => 'Light',
        'role' => 'Recon / Harass',
        'armor' => 40,
        'speed' => 95,
        'primary' => 'Light Auto-Cannon',
        'secondary' => 'SMG',
        'utility' => 'Sensor Ping',
        'description' => 'Fast and fragile, built for scouting and hit-and-run tactics.'
    ],
    [
        'name' => 'Frontline Bruiser',
        'class' => 'Medium',
        'role' => 'Frontline / Brawler',
        'armor' => 80,
        'speed' => 70,
        'primary' => 'Heavy Shotgun',
        'secondary' => 'Rocket Pod',
        'utility' => 'Deployable Shield',
        'description' => 'Balanced mech that excels in mid-range brawls and objective holding.'
    ],
    [
        'name' => 'Siege Breaker',
        'class' => 'Heavy',
        'role' => 'Siege / Long Range',
        'armor' => 110,
        'speed' => 45,
        'primary' => 'Railgun',
        'secondary' => 'Missile Barrage',
        'utility' => 'Target Painter',
        'description' => 'Slow but devastating. Ideal for breaking defenses from a distance.'
    ],
    [
        'name' => 'Support Anchor',
        'class' => 'Support',
        'role' => 'Heals / Buffs',
        'armor' => 70,
        'speed' => 60,
        'primary' => 'Beam Rifle',
        'secondary' => 'Repair Drone Launcher',
        'utility' => 'Area Buff Field',
        'description' => 'Keeps allies alive and boosted while still contributing consistent damage.'
    ],
];
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

        .loadout-class {
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 12px;
            background: #eee;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .loadout-role {
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

        .loadout-description {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    <header>
        <h1>MechMaker – Loadouts</h1>
        <!-- Change href if you want to go back to your main MechMaker page -->
        <a class="back-link" href="index.php">&larr; Back to MechMaker</a>
    </header>

    <div class="page-container">
        <h2 class="page-title">Available Loadouts</h2>
        <p class="page-subtitle">
            These are your current mech loadouts.
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
                                <div class="loadout-role">
                                    <?php echo htmlspecialchars($loadout['role']); ?>
                                </div>
                            </div>
                            <div class="loadout-class">
                                <?php echo htmlspecialchars($loadout['class']); ?>
                            </div>
                        </div>

                        <div class="stats-row">
                            <div class="stat-pill">
                                Armor: <?php echo (int) $loadout['armor']; ?>
                            </div>
                            <div class="stat-pill">
                                Speed: <?php echo (int) $loadout['speed']; ?>
                            </div>
                        </div>

                        <div class="weapons">
                            <span class="label">Primary:</span>
                            <?php echo htmlspecialchars($loadout['primary']); ?><br>
                            <span class="label">Secondary:</span>
                            <?php echo htmlspecialchars($loadout['secondary']); ?><br>
                            <span class="label">Utility:</span>
                            <?php echo htmlspecialchars($loadout['utility']); ?>
                        </div>

                        <div class="loadout-description">
                            <?php echo htmlspecialchars($loadout['description']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>