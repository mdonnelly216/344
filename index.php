<?php

$servername = "localhost";
$username = "root";  //user name
$password = "mdonnelly";  //password used to login MySQL server
$dbname = "mechmaker";
$conn = new mysqli("$servername", "$username", "$password", "$dbname");
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

// Function to pull weapons by type
function getWeapons($conn, $type)
{
    $stmt = $conn->prepare("SELECT name FROM weapon WHERE type = ?");
    $stmt->bind_param("s", $type);
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
</head>

<body>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Clients</a>
        <button onclick="location.href='loadoutPage.php'">Loadouts</button>
    </div>

    <div id="main">
        <div class="top-section">
            <h1>MechMaker</h1>

            <div class="search-container">
                <input type="text" id="buttonSearch" placeholder="Search options...">
            </div>
        </div>

        <hr>

        <div class="bottom-section">

            <!-- MISSILE MENU -->
            <div class="menu">
                <?php
                $results = getWeapons($conn, "Missile");
                while ($row = $results->fetch_assoc()):
                ?>
                    <button><?php echo htmlspecialchars($row['name']); ?></button>
                <?php endwhile; ?>
            </div>

            <!-- BALLISTIC MENU -->
            <div class="menu">
                <?php
                $results = getWeapons($conn, "Ballistic");
                while ($row = $results->fetch_assoc()):
                ?>
                    <button><?php echo htmlspecialchars($row['name']); ?></button>
                <?php endwhile; ?>
            </div>

            <!-- ENERGY MENU -->
            
            <div class="menu">
                <?php
                $results = getWeapons($conn, "Energy");
                while ($row = $results->fetch_assoc()):
                ?>
                    <button><?php echo htmlspecialchars($row['name']); ?></button>
                <?php endwhile; ?>
            </div>


            <div class="menu">
                <?php
                $result = $conn->query("SELECT name FROM weapon ORDER BY type, name");
                while ($row = $result->fetch_assoc()):
                ?>
                    <button><?php echo htmlspecialchars($row['name']); ?></button>
                <?php endwhile; ?>
            </div>

        </div>
    </div>

</body>

</html>

<?php $conn->close(); ?>