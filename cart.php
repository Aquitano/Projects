<?php
session_start();
require_once 'functions/search.php';
require_once 'includes/functions-inc.php';

$search = new DB();
$data = $search->viewData();

$searchInputHtml = '';
if (isset($_POST['search'])) {
    $searchInput = escapeHtml($_POST['search']);
    $searchInputHtml = "<div id='HomeSearch' style='display: none;'>$searchInput</div>";
}

$userId = isset($_SESSION['userid']) ? sanitizeInt($_SESSION['userid']) : null;
?>
<!DOCTYPE html>
<html lang="en">

<?php echo $searchInputHtml; ?>

<head>
    <!-- Meta-Tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="BetterGaming all games website." />
    <meta name="keywords" content="BetterGaming, Better Gaming, All games, games, Shopping" />
    <meta name="robots" content="index,follow" />
    <link rel="canonical" href="aquitano.ga/bettergaming/cart">
    <link rel="shortcut icon" href="img/logo.webp" type="image/x-icon" />
    <title>Shopping Cart - BetterGaming</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
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

    input,
    select {
        border: 1px solid #ff523b;
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
                <form class="field-c" action="games" method="POST">
                    <input type="text" placeholder="Search..." class="field" id="search" name="search"/>
                    <div class="icons-c">
                        <div class="icon-search"></div>
                        <div class="icon-close" onclick="document.getElementById('searchBox').value = ''; search('')">
                            <div class="x-up"></div>
                            <div class="x-down"></div>
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
                        echo "<li><a href='../includes/logout-inc.php'>Logout</a></li>";
                    }
                    ?>
                    <li><a href="#"><img src="img/cart.svg" alt="Cart" width="30px" height="30px"></a></li>

                </ul>
            </nav>
            <img src="img/menu.png" alt="menu" class="menu-icon" onclick="togglemenu()" />
        </div>
    </div>

    <!------------- Cart ------------->
    <?php
    if ($userId !== null) {
        $cart = $search->viewCart($userId);
        $subtotal = 0;
        $payment = 0.50;
    ?>
    <div class="small-c cart-page">

        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <!-- Checks if any game is out of stock and then removes it from the cart -->
            <?php foreach ($cart as $i) {
                    $gameName = escapeHtml($i["name"]);
                    $gameId = escapeHtml($i["id"]);
                    $gamePrice = escapeHtml($i["price"]);
                    $gameStock = (int)$i["available_stock"];
                    $gameQty = (int)$i["quantity"];
                    if ($gameStock == 0) {
                ?>
            <script>
            window.location.href = "includes/cart-inc.php?removecart=<?php echo $gameId; ?>";
            </script>
            <?php } ?>

            <tr>
                <td>
                    <div class="cart-info">
                        <img src="img/game/<?php echo $gameName; ?>.jpg" loading="lazy"
                            alt="<?php echo $gameName; ?>">
                        <div>
                            <p style="margin-bottom: 10px"><?php echo $gameName; ?></p>
                            <small style="margin-bottom: 10px">Price: <?php echo $gamePrice; ?>&#8364;</small>
                            <br />
                            <a href="includes/cart-inc.php?removecart=<?php echo $gameId; ?>"
                                style="margin-bottom: 10px">Remove</a>
                        </div>
                    </div>
                </td>
                <td><input type="number" value="<?php echo $gameQty; ?>" name="<?php echo $gameId; ?>"
                        max="<?php echo $gameStock; ?>" min="1"
                        onchange="changequantity(<?php echo $gameId; ?>, $(this).val());"></td>
                <td><?php echo $gamePrice * $gameQty; ?>&#8364;</td>
            </tr>
            <?php
                    $subtotal += $i["price"] * $gameQty;
                } ?>
        </table>
        <div class="total-price">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td id="subtotal"><?php echo $subtotal ?>€</td>
                </tr>
                <tr>
                    <td>
                        <select id="payment">
                            <option value="0">Paypal (+0,5€)</option>
                            <option value="1">PaySafeCard (+1,0€)</option>
                            <option value="2">Mastercard (+0€)</option>
                        </select>
                    </td>
                    <td>
                        <p></p>
                    </td>
                </tr>
                <tr>
                    <td>Payment cost: Paypal</td>
                    <td id="payment"><?php echo $payment ?>€</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td id="total"><?php echo $subtotal + $payment ?>€</td>
                </tr>
                <tr>
                    <td>
                        <div class="buttons__button" onclick="checkout()">
                            <button class="button button--slide" style="transform: translateX(35px);">
                                <span>Buy now!</span>
                            </button>
                        </div>
                    </td>
                    <td>
                        <p></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="success">
        <div>
            <div style="font-weight: bold;font-size: xx-large;">
                Payment Complete
            </div>
            <div>
                <i class="fa fa-check-circle-o fa-5x" aria-hidden="true" style="margin-top: 10px; color: green;"></i>
            </div>
            <div onclick="$('.success').css('display', 'none');">
                <i class="fa fa-times cross" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <?php } else {
        header("Location: account.php?error=mustlogin&site=login");
        exit();
    }
    ?>

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
    // Hides payment success pop up
    document.addEventListener("DOMContentLoaded", function(event) {

        $('.success').css('display', 'none');
    })

    // Checks if user was send here with existing search parameters
    if (document.getElementById("HomeSearch")) {
        document.getElementById('searchBox').value = document.getElementById('HomeSearch').innerHTML;
        search(document.getElementById('HomeSearch').innerHTML);
    }

    // If quantity is changed it's committed to database
    function changequantity(id, quantity) {
        $.post(
            "includes/cart-inc.php", {
                cid: id,
                quantity: quantity
            }
        );
        refresh();
    }

    // If clicked on checkout button it starts the payment process
    function checkout() {
        var total = parseFloat(($('#total').text()).replace("€", "").replace("&#8364;", ""));
        var payment = parseInt($('#payment option:selected').attr('value'));
        $.post(
            "includes/buy-inc.php", {
                total: total,
                payment: payment
            }
        );
        $('.success').css('display', '');
    }

    // Gets sorting and searching parameters and looking in database for them/it
    function refresh() {
        // Use session-based authentication instead of passing user ID
        fetch('functions/searchdata.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'user=<?php echo $userId; ?>',
                credentials: 'same-origin'
            })
            .then(res => res.json())
            .then(res => RefreshData(res))
            .catch(e => console.error('Error: ' + e))
    }

    // Displays database results after changing quantity of a game
    function RefreshData(data) {
        $(".cart-page").html("<table id='cart-table'><tr><th>Product</th><th>Quantity</th><th>Subtotal</th></tr>");
        var subtotal = 0;
        var payment = 0.50;

        for (let i = 0; i < data.length; i++) {
            const div = document.createElement("tr");
            div.innerHTML = "<td><div class='cart-info'><img src='img/game/" + data[i]["name"] +
                ".jpg' loading='lazy' alt='" + data[i]["name"] + "'><div><p style='margin-bottom: 10px'>" + data[i][
                    "name"
                ] + "</p><small style='margin-bottom: 10px'>Price:" + data[i]["price"] +
                "€</small><br /><a href='includes/cart-inc.php?removecart=" + data[i]["id"] +
                "' style='margin-bottom: 10px'>Remove</a></div></div></td><td><input type='number' value='" + data[i][
                    "quantity"
                ] + "' name='" + data[i]["id"] + "' max='100' min='1' id='input" + data[i]["id"] +
                "'onchange='changequantity(" + data[i]["id"] +
                ", $(this).val())'></td><td>" + data[i]["price"] * data[i]["quantity"] + "€</td>";
            $("#cart-table").append(div);
            subtotal += data[i]["price"] * data[i]["quantity"];
        }
        var total = parseFloat(payment) + parseFloat(subtotal);
        $(".cart-page").append("</table><div class='total-price'><table><tr><td>Subtotal</td><td id='subtotal'>" +
            subtotal +
            "€</td></tr><tr><td><select><option value='1'>Paypal (+0,5€)</option><option value='2'>PaySafeCard (+1,0€)</option><option value='3'>Mastercard (+0€)</option></select></td><td><p></p></td></tr><tr><td>Payment cost: Paypal</td><td id='payment'>" +
            payment +
            "€</td></tr><tr><td>Total</td><td id='total'>" + total +
            "€</td></tr><tr><td><div class='buttons__button'><button class='button button--slide' style='transform: translateX(35px);'><span>Buy now!</span></button></div></td><td><p></p></td></tr></table></div></div>"
        );
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
