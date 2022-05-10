<?php
require_once 'functions/search.php';

$search = new DB();
$featured = $search->viewFeatured();
$recent = $search->viewRecent();

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta-Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Homepage of the BetterGaming. Your Video Game Store!" />
    <meta name="keywords" content="BetterGaming, Better Gaming, Homepage, Landing-Page, Shopping" />
    <meta name="robots" content="index,follow" />
    <link rel="canonical" href="aquitano.ga/bettergaming/index">
    <link rel="shortcut icon" href="img/logo.webp" type="image/x-icon" />
    <title>Homepage - BetterGaming | Your Game Store</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style-min.css" />
    <style>
        a {
            text-decoration: none;
        }
    </style>

</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="p">LOADING</div>
    </div>
    <!-- Header -->
    <div class="c">
        <div class="navbar">
            <img src="img/logo.webp" alt="Logo" class="logo" />
            <div class="search">
                <form class="field-c" action="games" method="POST">
                    <input type="text" placeholder="Search..." class="field" id="search" name="search" />
                    <div class="icons-c">
                        <div class="icon-search"></div>
                        <div class="icon-close" onclick="document.getElementById('search').value = ''">
                            <div class="x-up"></div>
                            <div class="x-down"></div>
                        </div>
                    </div>
                </form>
            </div>
            <nav>
                <ul id="menuList">
                    <li><a href="#">Home</a></li>
                    <li><a href="games">Games</a></li>
                    <li><a href="account">Account</a></li>
                    <?php
                    if (isset($_SESSION["userid"])) {
                        echo "<li><a href='../includes/logout-inc.php'>Logout</a></li>";
                    }
                    ?>
                    <li><a href="cart"><img src="img/cart.svg" alt="Cart" width="30px" height="30px" style="transform: translateY(5px);"></a></li>
                </ul>
            </nav>
            <img src="img/menu.png" alt="menu" class="menu-icon" onclick="togglemenu()" />
        </div>
        <!-- Welcome items -->

        <div class="row">
            <div class="col-1 t1" id="t1">
                <h2>Buy Games Cheap!</h2>
                <h3>All your favorite games.</h3>
                <p>Instant Download. 24/7 Customer Service.</p>
                <h4></h4>
                <a href="games" style="text-decoration: none; color: #fff; ">
                    <button type="button">
                        Start Browsing
                        <img src="img/arrow.png" alt="Arrow" />
                    </button>
                </a>
            </div>

            <div class="col-2">
                <img src="img/landing.webp" class="controller" alt="Landing page home image" data-speed="-2.5" />
                <div class="color-box"></div>
            </div>
        </div>
    </div>

    <!------------- Featured games ------------->
    <div class="small-c" data-scroll>
        <h2 class="title">Featured Games</h2>
        <div class="row">
            <!-- Checks what games are featured and shows them here -->
            <?php foreach ($featured as $i) { ?>
                <a href="game/<?php echo $i["id"]; ?>" class="hover">
                    <div data-scroll class="col-4">
                        <img src="img/game/<?php echo $i["name"]; ?>.jpg" width="233" height="324" loading="lazy" alt="<?php echo $i["name"]; ?>" />
                        <h4><?php echo $i["name"]; ?></h4>
                        <p><?php echo $i["price"]; ?>€</p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>

    </div>

    <!------------- Recent games ------------->
    <div class="small-c" data-scroll>
        <h2 class="title">Recently Added</h2>
        <div class="row">
            <!-- Checks what games were most recently added and shows them here -->
            <?php foreach ($recent as $i) { ?>
                <a href="game/<?php echo $i["id"]; ?>" class="hover">
                    <div data-scroll class="col-4">
                        <img src="img/game/<?php echo $i["name"]; ?>.jpg" loading="lazy" alt="<?php echo $i["name"]; ?>" />
                        <h4><?php echo $i["name"]; ?></h4>
                        <p><?php echo $i["price"]; ?>€</p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>

    <!------------- brands ------------->
    <div class="brands" data-scroll>
        <div class="small-c">
            <h2 class="title">Games For</h2>
            <div class="row">
                <div class="col-5">
                    <img src="img/logo/Bethesda.webp" alt="Bethesda" loading="lazy" />
                </div>
                <div class="col-5">
                    <img src="img/logo/epic.webp" alt="Epic Games" loading="lazy" />
                </div>
                <div class="col-5">
                    <img src="img/logo/steam.webp" alt="Steam" loading="lazy" />
                </div>
                <div class="col-5">
                    <img src="img/logo/RockstarGames.webp" alt="Rockstar Games" loading="lazy" />
                </div>
                <div class="col-5">
                    <img src="img/logo/Ubisoft.webp" alt="Ubisoft" loading="lazy" />
                </div>
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
                <div class="col-4 lg" data-speed="-1.5">
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

    <!------------- JS scripts ------------->

    <script defer src="https://unpkg.com/scroll-out/dist/scroll-out.min.js"></script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/jquery-bez@1.0.11/src/jquery.bez.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js"></script>
    <script defer src="js/main-min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            Pace.on('done', function() {
                TweenMax.from(".navbar", 2, {
                    delay: 0.4,
                    y: 15,
                    opacity: 0,
                    ease: Expo.easeInOut,
                });

                TweenMax.from(".t1", 2, {
                    delay: 1.15,
                    x: -50,
                    opacity: 0,
                    ease: Expo.easeInOut,
                });

                TweenMax.from(".controller", 2, {
                    delay: 2.0,
                    x: -30,
                    opacity: 0,
                    ease: Expo.easeInOut,
                });

                TweenMax.from(".color-box", 2, {
                    delay: 1.45,
                    x: 45,
                    opacity: 0,
                    ease: Expo.easeInOut,
                });
            });
        });
    </script>

</body>

</html>