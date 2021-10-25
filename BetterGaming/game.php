<!DOCTYPE html>
<html lang="en">

<?php
require_once 'search.php';

$search = new DB();
$data = $search->viewData();
$single = $search->viewSingleGame($_GET["id"]);
$random = $search->viewRandom($_GET["id"]);
$category = $search->viewCategory($_GET["id"]);
?>

<head>
    <!-- Meta-Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Details of <?php foreach ($single as $i) {
                                                        echo $i["name"];
                                                    } ?>on the BetterGaming Games store." />
    <meta name="keywords" content="BetterGaming, Better Gaming, <?php foreach ($single as $i) {
                                                                    echo $i["name"];
                                                                } ?>" />
    <meta name="robots" content="index,follow" />
    <link rel="canonical" href="aquitano.ga/bettergaming/game/<?php echo $i["id"]; ?>">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon" />
    <title><?php foreach ($single as $i) {
                echo $i["name"];
            } ?> - BetterGaming | Your Game Store</title>
    <!-- CSS -->
    <link href="../css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style-min.css" />
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
        .description {
            text-align: justify;
        }
        .description h2 {
            color: #f50;
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .description h3 {
            font-weight: bold;
        }
        .description a {
            color: #f50;
            text-align: justify;
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
            <a href="../index"><img src="../img/logo.png" alt="Logo" class="logo" /></a>
            <div class="search">
                <fieldset class="field-c" action="../search" method="POST">
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
                    <li><a href="../index">Home</a></li>
                    <li><a href="../games">Games</a></li>
                    <li><a href="../account">Account</a></li>
                    <?php
                    if (isset($_SESSION["userid"])) {
                        echo "<li><a href='../includes/logout-inc.php'>Logout</a></li>";
                    }
                    ?>
                    <li><a href="../cart"><img src="../img/cart.svg" alt="Cart" width="30px" height="30px"></a></li>
                </ul>
            </nav>
            <img src="../img/menu.png" alt="menu" class="menu-icon" onclick="togglemenu()" />
        </div>
    </div>
    <!-- Single Product -->
    <!-- Search header (hidden) -->
    <div class="small-c single-item" data-scroll>
        <div class="row row-2" style="max-width: 1080px;">
            <h2 style="line-height: 60px; font-weight: bold; font-size: 45px;">All Products</h2>
            <select name="Sort " id="Sort" onchange="optionchange()">
                <option value="1">Sort by Name</option>
                <option value="2">Sort by price (Cheap to Expensive)</option>
                <option value="3">Sort by price (Expensive to Cheap)</option>
                <option value="4">Sort by added</option>
            </select>
        </div>
    <!-- Game information -->
        <?php foreach ($single as $i) { ?>
            <div class='row' style="align-content: center;justify-content: space-around;">
                <div class='grid grid-cols-1 gap-8 md:grid-cols-2' id='dataViewer'>

                    <div>
                        <img src="../img/game/<?php echo $i["name"]; ?>.jpg" alt="<?php echo $i["name"]; ?>" width='82%' />
                    </div>

                    <div>
                        <p class="font-light" style="margin-top:10px; margin-bottom:10px"><a href="../games">Games</a> /
                            <?php echo $i["name"]; ?></p>
                        <h1 class="font-bold text-8xl" id="Name"><?php echo $i["name"]; ?></h1>
                        <div class="tags">
                            <?php foreach ($category as $c) {
                                echo "<a>" . $c["name"] . "</a>";
                            } ?>
                        </div>
                        <h4 style="margin: 20px 0; font-size: 22px; font-weight: bold;"><?php echo $i["price"]; ?>€</h4>
                        <select>
                            <option value='1'>PC</option>
                            <option value='2'>PS5</option>
                            <option value='3'>XBOX</option>
                        </select>
                        <input type='number' id="quantity" value='1' min='1' max='<?php echo $i["available_stock"]; ?>'>

                <?php if ($i["available_stock"] == 0) { ?>
                        <div class='buttons__button'>
                            <button class='button button--slide'>
                                <span>OUT OF STOCK!</span>
                            </button>
                        </div>
                   <?php } else {?>
                        <div class='buttons__button'>
                            <button class='button button--slide' id='btn'>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <h3 class='font-bold text-2xl' style='margin-top:25px'>Product Details</h3>
            <div class="description"><?php echo $i["desc"]; ?></div>
        <?php } ?>
    </div>

    <!-- Other Products -->
    <div class="small-c" id="Other">
        <div class="row row-2">
            <h2 class="font-bold text-2xl">Other Products</h2>
            <a href="../games">
                <p>View More</p>
            </a>
        </div>
        <div class="row">
            <?php foreach ($random as $i) { ?>
                <a href="../game/<?php echo $i["id"]; ?>" class="hover">
                    <div data-scroll class="col-4">
                        <img src="../img/game/<?php echo $i["name"]; ?>.jpg" loading="lazy" alt="<?php echo $i["name"]; ?>" />
                        <h4><?php echo $i["name"]; ?></h4>
                        <p><?php echo $i["price"]; ?>€</p>
                    </div>
                </a>
            <?php } ?>
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
                            <a href="../ToU">Terms of Use</a>
                        </ul>
                        <ul>
                            <a href="../Payment">Payment</a>
                        </ul>
                        <ul>
                            <a href="../Privacy">Privacy policy</a>
                        </ul>
                    </ol>
                </div>
                <div class="col-4 lg">
                    <img src="../img/logo.png" alt="Logo" />
                    <h4 style="font-size: 85%">Copyright © 2021 BetterGaming - All rights reserved</h4>
                </div>
                <div class="col-4 pay">
                    <img src="../img/payment/paypal.png" alt="Paypal" />
                    <img src="../img/payment/psc.png" alt="PaySafeCard" />
                    <img src="../img/payment/visa.png" alt="Visa / Mastercard" />
                </div>
            </div>
        </div>
    </div>

    <!------------- JS Scripts ------------->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Adds game to shopping cart
        $('#btn').click(function() {
            var quantity = $('#quantity').val();
            window.location.href = "../includes/cart-inc.php?addcart=<?php foreach ($single as $i) {echo $i["id"]; } ?>&quantity=" + quantity;
        });

        once = 1;
        $('.row-2').hide();

        // Changes size of game name if it is too long
        if (document.getElementById("Name").innerHTML.length > 15) {
            $("#Name").toggleClass('text-8xl text-7xl');
        }

        // Checks if user was send here with existing search parameters
        if (document.getElementById("HomeSearch")) {
            document.getElementById(' searchBox').value = document.getElementById('HomeSearch').innerHTML;
            search(document.getElementById('HomeSearch').innerHTML);
        }

        // Gets sorting parameters from sort drop down
        function getoption() {
            output = document.querySelector('#Sort').value;
            return output;
        }

        // Gets searching parameters from search bar
        function optionchange() {
            value = document.querySelector('#searchBox').value;
            search(value);
        }

        // Starts searching for entered name
        function search(name) {
            fetchSearchData(name);
        }

        // Gets sorting and searching parameters and looking in database for them/it + displaying them
        function fetchSearchData(name) {
            option = getoption();
            let
                data = new URLSearchParams();
            data.append(`name`, name);
            data.append(`option`, option - 1);
            fetch('../searchdata.php', {
                    method: 'POST',
                    body: data
                }).then(res => res.json())
                .then(res => viewSearchResult(res))
                .catch(e => console.error('Error: ' + e))
        }

        // Displays database results
        function viewSearchResult(data) {
            // Hides game information
            $('.description').hide();
            $('.font-bold').hide();
            $('.row-2').show();
            const dataViewer = document.getElementById('dataViewer');

            // Turns fetched data to html to display search results
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
                div.innerHTML = "<a href='../game/" + data[i]["id"] + "'><img src='../img/game/" + data[i]["name"] +
                    ".jpg' alt='" + data[i]["name"] + "' />" + "<h4>" + data[i]["name"] + "</h4>" + "<p>" +
                    data[i]["price"] + "€</p></a>";
                dataViewer.appendChild(div);
                dataViewer.className = 'grid grid-cols-1 gap-4 md:grid-cols-4';
            }
            }
            // Changes grid settings for better styling
            if (once == 1) {
                $("#dataViewer").toggleClass('md:grid-cols-2 md:grid-cols-4');
                $('#Other').empty();
                once = 2;
            }
        }
    </script>
    <script defer src="https://unpkg.com/scroll-out/dist/scroll-out.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/jquery-bez@1.0.11/src/jquery.bez.js"></script>
    <script defer src="../js/main-min.js"></script>
</body>

</html>
