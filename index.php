<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MechMaker</title>
    <link rel="stylesheet" href="css.css">
    <script src="js.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #main {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .top-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        hr {
            margin: 0;
            border: none;
            border-top: 2px solid #ccc;
        }

        .bottom-section {
            flex: 1;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: #fafafa;
            padding: 20px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            width: 150px;
            height: 150px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .menu button {
            border: none;
            background: none;
            padding: 8px;
            cursor: pointer;
            text-align: left;
            transition: background-color 0.2s;
        }

        .menu button:hover {
            background-color: #f2f2f2;
        }

        .menu button.active {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Clients</a>
        <a href="#">Contact</a>
    </div>

    <div id="main">
        <div class="top-section">
            <h1>Top Section</h1>
        </div>

        <hr>

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

    <script>
        // Make only one button active per menu
        document.querySelectorAll('.menu').forEach(menu => {
            menu.addEventListener('click', e => {
                if (e.target.tagName === 'BUTTON') {
                    menu.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
                    e.target.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>