<!DOCTYPE html>
<html lang="en">

<?php

session_start();
require_once 'includes/functions-inc.php';
$csrfToken = generateCsrfToken();

?>

<head>
    <!-- Meta-Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Account page for managing your data and orders on the BetterGaming Games Store." />
    <meta name="keywords" content="BetterGaming, Better Gaming, Account, Your Account, Login, Register" />
    <link rel="canonical" href="aquitano.ga/bettergaming/account">
    <meta name="robots" content="index,follow" />
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon" />
    <title>Account - BetterGaming | Your Game Store</title>
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
            <a href="index"><img src="img/logo.png" alt="Logo" class="logo" /></a>
            <div class="search">
                <form class="field-c" action="games" method="POST">
                    <input type="text" placeholder="Search..." class="field" id="search" name="search" />
                    <div class="icons-c">
                        <div class="icon-search"></div>
                        <div class="icon-close" onclick="document.getElementById('searchBox').value = ''; search('')">
                            <div class="x-up"></div>
                            <div class="x-down"></div>
                            <select name="Sort " id="Sort" style="display: none">
                                <option value="1">Sort by Name</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <nav>
                <ul id="menuList">
                    <li><a href="index">Home</a></li>
                    <li><a href="games">Games</a></li>
                    <li><a href="account">Account</a></li>
                    <?php
                    if (isset($_SESSION["userid"])) {
                        echo "<li><a href='includes/logout-inc.php'>Logout</a></li>";
                    }
                    ?>
                    <li><a href="cart"><img src="img/cart.svg" alt="Cart" width="30px" height="30px"></a></li>
                </ul>
            </nav>
            <img src="img/menu.png" alt="menu" class="menu-icon" onclick="togglemenu()" />
        </div>
    </div>
    <!-- Account-Page -->
    <?php
    if (isset($_SESSION["userid"])) {
        if ($_SESSION["noaddress"] == 1) { ?>
    <div class="account-details">
        <div class="grid">
            <div class="form-btn">
                <span class="text-5xl">User Profile</span>
                <hr id="Indicator2">
            </div>

            <form action="includes/details-inc.php" method="post" id="Address">
                <input type="hidden" name="csrf_token" value="<?php echo escapeHtml($csrfToken); ?>">
                <input type="text" name="add_line" placeholder="Address Line 1..." autocomplete="address-line1">
                <input type="text" name="city" placeholder="City..." autocomplete="address-level2">
                <input type="text" name="postal" placeholder="Postal Code..." autocomplete="postal-code">
                <input type="text" name="country" placeholder="Country..." autocomplete="country-name">
                <input type="tel" name="phone" placeholder="Telephone number...(optional)" autocomplete="tel">
                <button type="submit" name="submit" class="btn" style="margin: 10px 350px">Save</button>
            </form>
        </div>
    </div>
    <?php } else { ?>
    <div class="account-details">
        <div class="grid">
            <div class="form-btn">
                <span class="text-5xl">Account</span>
                <hr id="Indicator2">
            </div>
            <div>Hey</div>
        </div>
    </div>
    <?php }
    } else { ?>
    <div class="account-page">
        <div class="c">
            <div class="row">
                <div class="col-2">
                    <img src="img/undraw_virtual_reality_y5ig.png" alt="Virtual Reality Drawing" />
                </div>
                <div class="col-2">
                    <div class="form-container">
                        <div class="form-btn">
                            <span onclick="login()">Login</span>
                            <span onclick="register()">Register</span>
                            <hr id="Indicator">
                        </div>

                        <!-- Login -->

                        <form action="includes/login-inc.php" method="post" id="LoginForm">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeHtml($csrfToken); ?>">
                            <input type="text" name="email" placeholder="Email..." autocomplete="email">
                            <input type="password" name="pwd" placeholder="Password..." autocomplete="current-password">
                            <button type="submit" name="submit" class="btn">Login</button>
                        </form>
                        <?php
                            if (isset($_GET["error"])) {
                                if ($_GET["error"] == "wronglogin") {
                                    echo "<p>Incorrect login information!</p>";
                                } else if ($_GET["error"] == "mustlogin") {
                                echo "<p>Please login to use shopping cart!</p>";
                            }}
                            ?>

                        <!-- Register -->

                        <form action="includes/signup-inc.php" method="post" id="RegForm">
                            <input type="hidden" name="csrf_token" value="<?php echo escapeHtml($csrfToken); ?>">
                            <input type="text" name="name" placeholder="Full name..." autocomplete="name">
                            <input type="email" name="email" placeholder="Email..." autocomplete="email">
                            <input type="password" name="pwd" placeholder="Password..." autocomplete="new-password">
                            <input type="password" name="pwdrepeat" placeholder="Repeat password..." autocomplete="new-password">
                            <button type="submit" name="submit" class="btn">Sign Up</button>
                        </form>
                        <?php
                            if (isset($_GET["error"])) {
                                if ($_GET["error"] == "emptyinput") {
                                    echo "<p>Fill in all fields!</p>";
                                } else if ($_GET["error"] == "invalidemail") {
                                    echo "<p>Please enter a valid email address!</p>";
                                } else if ($_GET["error"] == "nomatch") {
                                    echo "<p>Passwords do not match!</p>";
                                } else if ($_GET["error"] == "statmentfailed") {
                                    echo "<p>Something went wrong, try again!</p>";
                                } else if ($_GET["error"] == "emailtaken") {
                                    echo "<p>Email already taken!</p>";
                                } else if ($_GET["error"] == "security") {
                                    $pwderr = isset($_GET["pwderr"]) ? $_GET["pwderr"] : "";
                                    if ($pwderr == "length") {
                                        echo "<p>Password must be at least 8 characters!</p>";
                                    } else if ($pwderr == "uppercase") {
                                        echo "<p>Password must contain an uppercase letter!</p>";
                                    } else if ($pwderr == "lowercase") {
                                        echo "<p>Password must contain a lowercase letter!</p>";
                                    } else if ($pwderr == "number") {
                                        echo "<p>Password must contain a number!</p>";
                                    } else {
                                        echo "<p>Password does not meet security requirements!</p>";
                                    }
                                } else if ($_GET["error"] == "csrf") {
                                    echo "<p>Security validation failed. Please try again.</p>";
                                } else if ($_GET["error"] == "none") {
                                    echo "<p>You have signed up!</p>";
                                }
                            }
                            ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>


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
                    <img src="img/logo.png" alt="Logo" />
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
    // Site URL Parameter
    document.addEventListener("DOMContentLoaded", function(event) {
        let params = new URLSearchParams(document.location.search.substring(1));
        const site = params.get('site');
        if (site == "login") {
            login();
        }
        if (site == "register") {
            register();
        }
    });

    // Toggle Form

    var LoginForm = document.getElementById("LoginForm");
    var RegForm = document.getElementById("RegForm");
    var Indicator = document.getElementById("Indicator");

    function login() {
        RegForm.style.transform = "translateX(420px)";
        RegForm.style.opacity = "0";
        LoginForm.style.transform = "translateX(400px)";
        LoginForm.style.opacity = "1";
        Indicator.style.transform = "translateX(12px)";
    }

    function register() {
        RegForm.style.transform = "translateX(5px)";
        RegForm.style.opacity = "1";
        LoginForm.style.opacity = "0";
        LoginForm.style.transform = "translateX(-75px)";
        Indicator.style.transform = "translateX(132px)";
    }
    </script>
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="js/scroll-out.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/jquery-bez@1.0.11/src/jquery.bez.js"></script>
    <script defer src="js/main-min.js"></script>
</body>

</html>
