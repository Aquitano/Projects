<!DOCTYPE html>
<html lang="en">

<?php
require_once 'includes/search.php';

$search = new DB();
$data = $search->viewData();

if (isset($_POST['search'])) {
    $searchInput = htmlspecialchars($_POST['search']);
    echo "<div id='HomeSearch' style='display: none;'>$searchInput</div>";
}

?>

<head>
    <!-- Meta-Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Page with all available games to be purchased on the BetterGaming Games Store." />
    <meta name="keywords" content="BetterGaming, Better Gaming, All games, games, Shopping" />
    <meta name="robots" content="index,follow" />
    <link rel="canonical" href="aquitano.ga/bettergaming/games">
    <link rel="shortcut icon" href="img/logo.webp" type="image/x-icon" />
    <title>All Games - BetterGaming | Your Game Store</title>
    <!-- CSS -->
    <link href="css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style-min.css" />
    <style>
        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: inline-block;
            vertical-align: middle;
        }
        h4 {
            color: #555;
            font-weight: 600;
        }
        .grid p {
            font-size: 16px;
            color: #838383;
            font-weight: 100;
        }
        .noresult {
            margin-top: 150px;
            margin-bottom: 150px;
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="p">LOADING</div>
    </div>
    <!-- Header -->
    <div class="c" style="min-height: 10vh;">
        <div class="navbar">
            <a href="index"><img src="img/logo.webp" alt="Logo" class="logo" /></a>
            <div class="search">
                <fieldset class="field-c" action="includes/search.php" method="POST">
                    <input type="text" placeholder="Search..." class="field" id="searchBox" OnInput=search(this.value) />
                    <div class="icons-c">
                        <div class="icon-search"></div>
                        <div class="icon-close" onclick="document.getElementById('searchBox').value = ''; search('')">
                            <div class="x-up"></div>
                            <div class="x-down"></div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <nav>
                <ul id="menuList">
                    <li><a href="index">Home</a></li>
                    <li><a href="#">Games</a></li>
                    <li><a href="account">Account</a></li>
                    <?php
                    if (isset($_SESSION["userid"])) {
                        echo "<li><a href='../includes/logout-inc.php'>Logout</a></li>";
                    }
                    ?>
                    <li><a href="cart"><img src="img/cart.svg" alt="Cart" width="30px" height="30px"></a></li>
                </ul>
            </nav>
            <img src="img/menu.png" alt="menu" class="menu-icon" onclick="togglemenu()" />
        </div>
    </div>

    <!------------- All games ------------->
    <div class="small-c" data-scroll style="max-width: 2080px;">
        <div class="row row-2" style="max-width: 1080px;">
            <h2 style="line-height: 60px; font-weight: bold; font-size: 45px;">All Products</h2>
            <select name="Sort " id="Sort" onchange="optionchange()">
                <option value="1">Sort by Name</option>
                <option value="2">Sort by price (Cheap to Expensive)</option>
                <option value="3">Sort by price (Expensive to Cheap)</option>
                <option value="4">Sort by added</option>
            </select>
        </div>
        <div class="row" style="align-content: center;justify-content: space-around;">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4" id="dataViewer">
                <?php foreach ($data as $i) { ?>
                    <a href="game/<?php echo $i["id"]; ?>" class="hover">
                        <div data-scroll>
                            <img src="img/game/<?php echo $i["name"]; ?>.jpg" loading="lazy" alt="<?php echo $i["name"]; ?>" />
                            <h4><?php echo $i["name"]; ?></h4>
                            <p><?php echo $i["price"]; ?>€</p>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>

    <!------------- Footer ------------->
    <div class="footer">
        <div class="c">
            <div class="row">
                <div class="col-4">
                    <h4 style="margin-bottom: 15px">Useful Links</h4>
                    <ol>
                        <ul>
                            <a href="ToU">Terms of Use</a>
                        </ul>
                        <ul>
                            <a href="Payment">Payment</a>
                        </ul>
                        <ul>
                            <a href="Privacy">Privacy policy</a>
                        </ul>
                    </ol>
                </div>
                <div class="col-4 lg">
                    <img src="img/logo.webp" alt="Logo" />
                    <h4 style="font-size: 85%">Copyright © 2021 BetterGaming - All rights reserved</h4>
                </div>
                <div class="col-4 pay">
                    <img src="img/payment/paypal.png" alt="Paypal" />
                    <img src="img/payment/psc.png" alt="PaySafeCard" />
                    <img src="img/payment/visa.png" alt="Visa / Mastercard" />
                </div>
            </div>
        </div>
    </div>

    <!------------- JS Scripts ------------->

    <script>
        // Checks if user was send here with existing search parameters
        if (document.getElementById("HomeSearch")) {
            document.getElementById('searchBox').value = document.getElementById('HomeSearch').innerHTML;
            search(document.getElementById('HomeSearch').innerHTML);
        }

        // Gets sorting parameters from sort drop down
        function getoption() {
            output = document.querySelector('#Sort').value;
            return output;
        }

        // Gets searching parameters from search bar
        function optionchange() {
            value = document.querySelector('#searchBox').value
            search(value);
        }

        // Starts searching for entered name
        function search(name) {
            fetchSearchData(name);
        }

        // Gets sorting and searching parameters and looking in database for them/it
        function fetchSearchData(name) {
            option = getoption();

            let data = new URLSearchParams();
            data.append(`name`, name);
            data.append(`option`, option - 1);

            fetch('includes/searchdata.php', {
                    method: 'POST',
                    body: data
                })
                .then(res => res.json())
                .then(res => viewSearchResult(res))
                .catch(e => console.error('Error: ' + e))
        }

        // Displays database results
        function viewSearchResult(data) {
            const dataViewer = document.getElementById('dataViewer');

            dataViewer.innerHTML = "";

            if(jQuery.isEmptyObject(data) == true) {
                const div = document.createElement("div");
                div.className = 'hover noresult';
                div.innerHTML = "<a>No results for your search found! <br /> Please try again!</a>";
                dataViewer.appendChild(div);
                dataViewer.className = 'grid grid-cols-1 gap-4 md:grid-cols-1';
            } else {

            for (let i = 0; i < data.length; i++) {
                const div = document.createElement("div");
                div.className = 'hover';
                div.innerHTML = "<a href='game/" + data[i]["id"] + "'><img src='img/game/" + data[i]["name"] +
                    ".jpg' alt='" + data[i]["name"] + "' />" +
                    "<h4>" + data[i]["name"] + "</h4>" + "<p>" + data[i]["price"] + "€</p></a>";
                dataViewer.appendChild(div);
                dataViewer.className = 'grid grid-cols-1 gap-4 md:grid-cols-4';
            }
        }
        }
    </script>
    <script defer src="https://unpkg.com/scroll-out/dist/scroll-out.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/jquery-bez@1.0.11/src/jquery.bez.js"></script>
    <script defer src="js/main-min.js"></script>
</body>

</html>
