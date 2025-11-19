<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MechMaker</title>
    <link rel="stylesheet" href="css.css">
    <script src="js.js" defer></script>
</head>

<body>
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="loadoutPage.php">Loadouts</a>
    </div>

    <div id="main">
        <div class="top-section">
            <h1>Top Section</h1>
        </div>

        <hr>

        <div class="search-container">
            <input type="text" id="buttonSearch" placeholder="Search options...">
        </div>

        <div class="bottom-section">

            <div class="menu">
                <button>Option 1A</button>
                <button>Option 1B</button>
                <button>Option 1C</button>
                <button>Option 1D</button>
                <button>Option 1E</button>
            </div>

            <div class="menu">
                <button>Option 2A</button>
                <button>Option 2B</button>
                <button>Option 2C</button>
                <button>Option 2D</button>
            </div>

            <div class="menu">
                <button>Option 3A</button>
                <button>Option 3B</button>
                <button>Option 3C</button>
                <button>Option 3D</button>
                <button>Option 3E</button>
            </div>

            <div class="menu">
                <button>Option 4A</button>
                <button>Option 4B</button>
                <button>Option 4C</button>
            </div>
        </div>
    </div>


</body>

</html>