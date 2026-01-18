<?php

if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
include 'variables.php';

class DB
{
    private $con;

    public function __construct()
    {
        global $var_host, $var_db, $var_username, $var_pas;
        $dsn = "mysql:host=" . $var_host . ";dbname=" . $var_db . ";charset=utf8mb4";

        try {
            $this->con = new PDO($dsn, $var_username, $var_pas);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }

    public function viewData()
    {
        $query = "SELECT id, name, price, available_stock FROM product ORDER BY name";
        $statement = $this->con->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewFeatured()
    {
        $query = "SELECT id, name, price FROM product WHERE featured = 1 LIMIT 4";
        $statement = $this->con->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewRecent()
    {
        $query = "SELECT id, name, price FROM product ORDER BY id DESC LIMIT 4";
        $statement = $this->con->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewRandom($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            return [];
        }
        $query = "SELECT id, name, price FROM product WHERE id != :id ORDER BY RAND() LIMIT 4";
        $statement = $this->con->prepare($query);
        $statement->execute([":id" => $id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewSingleGame($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            return [];
        }
        $query = "SELECT * FROM product WHERE id = :id LIMIT 1";
        $statement = $this->con->prepare($query);
        $statement->execute([":id" => $id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewCategory($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            return [];
        }
        $query = "SELECT product_category.name FROM product
                  INNER JOIN product_to_category ON product.id = product_to_category.product_id
                  INNER JOIN product_category ON product_category.id = product_to_category.category_id
                  WHERE product.id = :id";
        $statement = $this->con->prepare($query);
        $statement->execute([":id" => $id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewCart($id)
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            return [];
        }
        $query = "SELECT product.id, product.name, product.price, product.available_stock, cart_item.quantity
                  FROM cart_item
                  INNER JOIN product ON cart_item.product_id = product.id
                  INNER JOIN user ON cart_item.user_id = user.id
                  WHERE user.id = :id";
        $statement = $this->con->prepare($query);
        $statement->execute([":id" => $id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getorderid($payment)
    {
        if (empty($payment) || !preg_match('/^[a-z0-9]+$/i', $payment)) {
            return [];
        }
        $query = "SELECT id FROM order_details WHERE payment_id = :payment";
        $statement = $this->con->prepare($query);
        $statement->execute([":payment" => $payment]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKey($game)
    {
        $game = filter_var($game, FILTER_VALIDATE_INT);
        if ($game === false) {
            return [];
        }
        $query = "SELECT product_key FROM product_unused_keys WHERE product_id = :game LIMIT 1";
        $statement = $this->con->prepare($query);
        $statement->execute([":game" => $game]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchData($name, $option)
    {
        $sortOptions = [
            0 => "product.name ASC",
            1 => "product.price ASC",
            2 => "product.price DESC",
            3 => "product.id DESC"
        ];

        $option = filter_var($option, FILTER_VALIDATE_INT);
        if ($option === false || !isset($sortOptions[$option])) {
            $option = 0;
        }

        $query = "SELECT DISTINCT product.id, product.name, product.price
                  FROM product
                  INNER JOIN product_to_category ON product.id = product_to_category.product_id
                  INNER JOIN product_category ON product_category.id = product_to_category.category_id
                  WHERE LOWER(product.name) LIKE LOWER(:name) OR LOWER(product_category.name) LIKE LOWER(:name)
                  ORDER BY " . $sortOptions[$option];
        $statement = $this->con->prepare($query);
        $statement->execute([":name" => "%" . $name . "%"]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
