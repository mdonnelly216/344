<?php

$servername = "localhost";
$username = "root";  
$password = "mdonnelly";  
$dbname = "mechmaker";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

function getWeapons($conn, $type)
{
    $stmt = $conn->prepare("SELECT name FROM weapon WHERE type = ?");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    return $stmt->get_result();
}

function getMechs($conn)
{
    $stmt = $conn->prepare("SELECT name FROM mech");
    $stmt->execute();
    return $stmt->get_result();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MechMaker</title>
    <link rel="stylesheet" href="css.css">
    <script src="js.js" defer></script>
    <script src="print.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</head>

<body>

    
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

    <!-- Side Navigation -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="loadoutPage.php">Loadouts</a>

        <div class="search-container">
            <input type="text" id="mechSearch" placeholder="Search Mechs...">
        </div>

        <?php
        // mech menu
        $mechs = $conn->query("SELECT mech_id, name, no_weapons FROM mech ORDER BY name");
        ?>
        <div class="mechMenu">
            <?php while ($row = $mechs->fetch_assoc()): ?>
                <button
                    type="button"
                    data-mech-id="<?= (int)$row['mech_id'] ?>"
                    data-no-weapons="<?= (int)$row['no_weapons'] ?>">
                    <?= htmlspecialchars($row['name']) ?>
                </button>
            <?php endwhile; ?>
        </div>
        
    </div>

    <div>
        <input type="button" value="Print Loadout" onclick="printPDF()"></button>
    </div>

    <div id="main">

        <div class="top-section">
            <h1>MechMaker</h1>
            <div id="mechWrapper">
                <img id="mechDisplay" src="">
                <div id="overlayShortDMG" class="overlayText" >0</div>
                <div id="overlayMedDMG" class="overlayText" >0</div>
                <div id="overlayLongDMG" class="overlayText" >0</div>
            </div>
    
            <div class="weaponSlots">
                <div class="weaponSlot"></div>
                <div class="weaponSlot"></div>
                <div class="weaponSlot"></div>
                <div class="weaponSlot"></div>
                <div class="weaponSlot"></div>
                <div class="weaponSlot"></div>
                <div class="weaponSlot"></div>
                <div class="weaponSlot"></div>
            </div>

        </div>

        <hr>

        <div class="search-container">
            <input type="text" id="buttonSearch" placeholder="Search options...">
        </div>

        <div class="bottom-section">

            <div class="bottom-section">

                <?php
                // Get all weapons
                $weapons = $conn->query("
                    SELECT weapon_id, name, type
                    FROM weapon
                    ORDER BY type, name
                ");

                $missiles   = [];
                $ballistics = [];
                $energy     = [];

                //split weapons by type

                while ($w = $weapons->fetch_assoc()) {
                    $type = strtolower($w['type']);

                    if ($type === 'missile') {
                        $missiles[] = $w;
                    } elseif ($type === 'ballistic') {
                        $ballistics[] = $w;
                    } elseif ($type === 'energy') {
                        $energy[] = $w;
                    }
                }
                ?>

                <div class="menu-container">
                    <div class="menu-label">Missile</div>
                    <div class="menu">
                        <?php foreach ($missiles as $w): ?>
                            <button type="button"
                                data-weapon-id="<?= (int)$w['weapon_id'] ?>">
                                <?= htmlspecialchars($w['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="menu-container">
                    <div class="menu-label">Ballistic</div>
                    <div class="menu">
                        <?php foreach ($ballistics as $w): ?>
                            <button type="button"
                                data-weapon-id="<?= (int)$w['weapon_id'] ?>">
                                <?= htmlspecialchars($w['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="menu-container">
                    <div class="menu-label">Energy</div>
                    <div class="menu">
                        <?php foreach ($energy as $w): ?>
                            <button type="button"
                                data-weapon-id="<?= (int)$w['weapon_id'] ?>">
                                <?= htmlspecialchars($w['name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                </div>


                <button type="button" onclick="addWeapon()">Add Selected Weapon</button>


            </div>
            <div id="loadoutControls" style="margin-top:20px; text-align:center;">
                <input type="text" id="loadoutName" placeholder="New loadout name">

                <button type="button" id="saveLoadoutBtn">
                    Save Loadout
                </button>

                <br><br>

                <select id="loadoutSelect">
                    <option value="">-- Select saved loadout --</option>
                    <?php
                    $res = $conn->query("
                        SELECT l.loadout_id, l.name, m.name AS mech_name
                        FROM loadout l
                        JOIN mech m ON l.mech_id = m.mech_id
                        ORDER BY l.loadout_id DESC
                    ");
                    while ($row = $res->fetch_assoc()):
                    ?>
                        <option value="<?= (int)$row['loadout_id'] ?>">
                            <?= htmlspecialchars($row['name'] . ' (' . $row['mech_name'] . ')') ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="button" id="loadLoadoutBtn">
                    Load
                </button>
            </div>
        </div>
        



</body>

</html>

<?php $conn->close(); ?>