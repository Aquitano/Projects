<?php

if(count(get_included_files()) ==1) exit("Direct access not permitted.");

class DB
{
    // Connection to MySQL database. Trying connection. Exception on Failure
    private $con;
    private $host = '';
    private $dbname = '';
    private $user = '';
    private $password = '';

    public function __construct()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;

        try {
            $this->con = new PDO($dsn, $this->user, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Failure" . $e->getMessage();
        }
    }

    // Returns all games via MySQL query (+ Prevention of SQL Injection)

    public function viewData()
    {
        $query = "SELECT id, name, price, available_stock FROM product ORDER BY name";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Returns featured games via MySQL query (+ Prevention of SQL Injection)

    public function viewFeatured()
    {
        $query = "SELECT id, name, price FROM product WHERE featured = 1 LIMIT 4";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Returns recent games via MySQL query (+ Prevention of SQL Injection)

    public function viewRecent()
    {
        $query = "SELECT id, name, price FROM product ORDER BY id DESC LIMIT 4";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Returns random games via MySQL query (+ Prevention of SQL Injection)

    public function viewRandom($id)
    {
        $query = "SELECT id, name, price FROM product WHERE NOT id = $id ORDER BY RAND() LIMIT 4";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Returns single games via MySQL query (+ Prevention of SQL Injection)

    public function viewSingleGame($id)
    {
        $query = "SELECT * FROM product WHERE id = $id LIMIT 1";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Returns all categories for game via MySQL query (+ Prevention of SQL Injection)

    public function viewCategory($id)
    {
        $query = "SELECT product_category.name FROM product, product_to_category, product_category WHERE product.id = $id AND product.id = product_to_category.product_id AND product_category.id = product_to_category.category_id";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function viewCart($id)
    {
        $query = "SELECT product.id, product.name, product.price, product.available_stock, cart_item.quantity FROM cart_item, product, user WHERE user.id = $id AND cart_item.user_id = user.id AND cart_item.product_id = product.id";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getorderid($payment)
    {
        $query = "SELECT id FROM order_details WHERE payment_id = '$payment';";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getKey($Game){
        $query = "SELECT product_key FROM product_unused_keys WHERE product_id = $Game LIMIT 1";
        $statement = $this->con->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Returns games that matches (LIKE) name and ordered by option (+ Prevention of SQL Injection)

    public function searchData($name, $option)
    {
        $sort = array("product.name", "product.price", "product.price DESC", "product.id DESC");
        $query = "SELECT DISTINCT product.id, product.name, product.price FROM product, product_to_category, product_category WHERE product.id = product_to_category.product_id AND product_category.id = product_to_category.category_id AND (LOWER(product.name) LIKE LOWER(:name) OR LOWER(product_category.name) LIKE LOWER(:name))ORDER BY $sort[$option]";
        $statement = $this->con->prepare($query);
        $statement->execute(["name" => "%" . $name . "%"]);
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
