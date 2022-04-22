<?php

if (count(get_included_files()) == 1) {exit("Direct access not permitted.");}

session_start();

$stmt_failed = "Location: ../cart.php?error=statmentfailed";

// Account SignUp

// Checking if any Signup field is empty

function emptyInputSignup($name, $email, $pwd, $pwdRepeat)
{
    if (empty($name) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Checking if entered email is a valid email

function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Checking if the two entered password match

function pwdMatch($pwd, $pwdRepeat)
{
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Checking if password meets security standards

function pwdSecurity($pwd)
{
    if (strlen($pwd) < 8) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


// Checking if entered email is in database

function emailExists($con, $email)
{
    $sql = "SELECT * FROM user WHERE email = ? LIMIT 1;";
    $statement = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../account.php?error=statmentfailed&site=register");
        exit();
    }

    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);

    $resultData = mysqli_stmt_get_result($statement);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $result = $row;
    } else {
        $result = false;
    }

    mysqli_stmt_close($statement);
    return $result;
}

// Adding User to database

function createUser($con, $name, $email, $pwd)
{
    $sql = "INSERT INTO user (first_name, last_name, email, email_verified, password) VALUES(?, ?, ?, ?, ?);";
    $statement = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../account.php?error=statmentfailed&site=register");
        exit();
    }

    // Hashing and Salting Password & Splits name into First and Last name

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $arrayName = explode(" ", $name);

    $null = 0;

    mysqli_stmt_bind_param($statement, "sssis", $arrayName[0], $arrayName[1], $email, $null, $hashedPwd);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    $emailExists = emailExists($con, $email);
    $_SESSION["noaddress"] = "1";
    $_SESSION["userid"] = $emailExists["id"];
    $_SESSION["email"] = $emailExists["email"];

    header("Location: ../account.php?error=none");
    exit();
}

// Account Login

//Checking if Login Input fields are empty
function emptyInputLogin($email, $pwd)
{
    if (empty($email) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Logging in User
function loginUser($con, $email, $pwd)
{
    // Checks if email exists
    $emailExists = emailExists($con, $email);

    if (!$emailExists) {
        header("location: ../account.php?error=wronglogin&site=login");
        exit();
    }

    // Getting hashed password and verifying it with entered password

    $pwdHashed = $emailExists["password"];

    $checkPwd = password_verify($pwd, $pwdHashed);

    if (!$checkPwd) {
        header("location: ../account.php?error=wronglogin&site=login");
        exit();
    } else if ($checkPwd) {
        // Logging User in % Setting session variables
        $_SESSION["noaddress"] = "0";
        if (!addressset($con, $email)) {
            $_SESSION["noaddress"] = "1";
        }
        $_SESSION["userid"] = $emailExists["id"];
        $_SESSION["email"] = $emailExists["email"];
        header("Location: ../account");
        exit();
    }
}

// Account details

// Checks if a address is set for current logged in account
function addressset($con, $email)
{
    $sql = "SELECT id FROM user WHERE NOT address IS NULL AND email = ? LIMIT 1;";
    $statement = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../account.php?error=statmentfailed&site=login");
        exit();
    }

    mysqli_stmt_bind_param($statement, "s", $email);
    mysqli_stmt_execute($statement);

    $resultData = mysqli_stmt_get_result($statement);

    if (!mysqli_fetch_assoc($resultData)) {
        $result = false;
    } else {
        $result = true;
    }

    mysqli_stmt_close($statement);
    return $result;
}

// Checking if any Input field is empty

function emptyDetails($add_line, $city, $postal, $country)
{
    if (empty($add_line) || empty($city) || empty($postal) || empty($country)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// Adds User Details to Database

function addDetails($con, $phone, $add_line, $city, $postal, $country)
{
    $user = $_SESSION["userid"];
    $sql = "UPDATE user SET phone=?, address=?, city=?, postal_code=?, country=? WHERE id = ?;";
    $statement = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../account.php?error=statmentfailed");
        exit();
    }

    mysqli_stmt_bind_param($statement, "sssisi", $phone, $add_line, $city, $postal, $country, $user);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    $_SESSION["noaddress"] = "0";

    header("Location: ../account.php?error=none");
    exit();
}

// Add game to cart

function addCart($con, $game, $user, $quantity)
{
    $sql = "INSERT INTO cart_item (product_id, user_id, quantity) VALUES(?, ?, ?);";
    $statement = mysqli_stmt_init($con);
    global $stmt_failed;
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: $stmt_failed");
        exit();
    }

    mysqli_stmt_bind_param($statement, "iii", $game, $user, $quantity);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    exit();
}

// Remove game from cart
function removeCart($con, $game, $user)
{
    $sql = "DELETE FROM cart_item WHERE product_id = ? AND user_id = ?;";
    $statement = mysqli_stmt_init($con);
    global $stmt_failed;
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: $stmt_failed");
        exit();
    }

    mysqli_stmt_bind_param($statement, "ii", $game, $user);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    header("Location: ../cart");
    exit();
}

// Change quantity of a game in cart
function updateQuantity($con, $id, $user, $quantity)
{
    $sql = "UPDATE cart_item SET quantity = ? WHERE user_id = ? AND product_id = ?;";
    $statement = mysqli_stmt_init($con);
    global $stmt_failed;
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header($stmt_failed);
        exit();
    }

    mysqli_stmt_bind_param($statement, "iii", $quantity, $user, $id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    header("Location: ../games");
    exit();
}

// Adds order to database if payment was successful
function checkout($con, $user, $total, $payment_type)
{
    $sql = "INSERT INTO order_details (user_id, total, payment_type, payment_id, status) VALUES(?, ?, ?, ?, ?);";
    $statement = mysqli_stmt_init($con);
    global $stmt_failed;
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: $stmt_failed");
        exit();
    }

    $payment_id = uniqid();
    $payment = array("Paypal", "PaySafeCard", "Mastercard");
    $status = "paid";
    mysqli_stmt_bind_param($statement, "iisss", $user, $total, $payment[$payment_type], $payment_id, $status);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    checkout_items($con, $user, $payment_id);

    exit();
}

// Adds items/games from a successful order to database
function checkout_items($con, $user, $payment_id)
{
    require_once '../search.php';

    $search = new DB();
    $cart = $search->viewCart($user);
    $order = $search->getorderid($payment_id);

    foreach ($order as $i) {
        $payment = $i["id"];
    }

    foreach ($cart as $i) {

        $sql = "INSERT INTO order_item (order_id, product_id, quantity) VALUES(?, ?, ?);";

        $statement = mysqli_stmt_init($con);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            header($stmt_failed);
            exit();
        }

        mysqli_stmt_bind_param($statement, "iii", $payment, $i["id"], $i["quantity"]);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);

        for ($x = 1; $x <= $i["quantity"]; $x++) {
            insertkey($con, $payment, $i["id"]);
        }
        updatestock($con, $i["id"], $i["quantity"]);
    }
}

// Insert product/game key to database. Gets key(s) out of unused_keys table.
function insertkey($con, $order, $product)
{
    $sql = "INSERT INTO order_key (order_item_id, product_key) VALUES(?, ?); ";
    $statement = mysqli_stmt_init($con);
    global $stmt_failed;
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: $stmt_failed");
        exit();
    }

    // Fetches game key(s) for bought games
    require_once '../search.php';

    $search = new DB();
    $pk = $search->getKey($product);

    foreach ($pk as $p) {
        $product_key = $p["product_key"];
    }
    $productid = getitemid($con, $product, $order);

    // Executes statment
    mysqli_stmt_bind_param($statement, "is", $productid, $product_key);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    deletekey($con, $product_key);
}

// Updates available stock after a successful order of a game
function updatestock($con, $product, $quantity)
{
    $sql = "UPDATE product SET available_stock = available_stock - '$quantity' WHERE id = '$product';";
    mysqli_query($con, $sql);
}

// Get itemid from product and order id
function getitemid($con, $product, $order)
{
    $sql = "SELECT id FROM order_item WHERE product_id = '$product' AND order_id = '$order';";
    $result = mysqli_query($con, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $id = $row['id'];
        }
    }
    return $id;
}

// Delete product/game key of a game after successful order
function deletekey($con, $product_key)
{
    $sql = "DELETE FROM `product_unused_keys` WHERE `product_unused_keys`.`product_key` = ?;";
    $statement = mysqli_stmt_init($con);
    global $stmt_failed;
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: $stmt_failed");
        exit();
    }

    mysqli_stmt_bind_param($statement, "s", $product_key);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
}