<?php

$servername = "localhost";
$username = "root";  //user name
$password = "4356An3?";  //password used to login MySQL server
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>

    <!-- Hamburger icon -->
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

    <!-- Side Navigation -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="loadoutPage.php">Loadouts</a>

        <div class="search-container">
            <input type="text" id="mechSearch" placeholder="Search Mechs...">
        </div>

        <div class="mechMenu">
            <?php
                $results = getMechs($conn);
                while ($row = $results->fetch_assoc()):
            ?>
            <button>
                <?php 
                    echo htmlspecialchars($row['name']); 
                ?>
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
            <div class=mechImage>
                <img id = mechDisplay src="Images/atlas.png" alt="MechMaker Logo" class="logo">
            </div>
            <div class="weaponSlots">
                <div class="weaponSlot">1</div>
                <div class="weaponSlot">2</div>
                <div class="weaponSlot">3</div>
                <div class="weaponSlot">4</div>
                <div class="weaponSlot">5</div>
                <div class="weaponSlot">6</div>
                <div class="weaponSlot">7</div>
                <div class="weaponSlot">8</div>
            </div>

        </div>

        <hr>

        <div class="search-container">
            <input type="text" id="buttonSearch" placeholder="Search options...">
        </div>

        <div class="bottom-section">

            <!-- MISSILE MENU -->
            <div class="menu-container">
                <p class="menu-label">Missile</p>
                <div class="menu">
                    <?php
                    $results = getWeapons($conn, "Missile");
                    while ($row = $results->fetch_assoc()):
                    ?>
                        <button><?php echo htmlspecialchars($row['name']); ?></button>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- BALLISTIC MENU -->
            <div class="menu-container">
                <p class="menu-label">Ballistic</p>

                <div class="menu">
                    <?php
                    $results = getWeapons($conn, "Ballistic");
                    while ($row = $results->fetch_assoc()):
                    ?>
                        <button><?php echo htmlspecialchars($row['name']); ?></button>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- ENERGY MENU -->
            <div class="menu-container">
                <p class="menu-label">Energy</p>
                <div class="menu">
                    <?php
                    $results = getWeapons($conn, "Energy");
                    while ($row = $results->fetch_assoc()):
                    ?>
                        <button><?php echo htmlspecialchars($row['name']); ?></button>
                    <?php endwhile; ?>
                </div>
            </div>



        </div>
    </div>

</body>

</html>

<?php $conn->close(); ?>