<?php

require_once('includes/search.php');

if (isset($_POST["name"])) {
    // Getting POST Data
    $name = $_POST['name'];
    $option = $_POST['option'];

    // Creating Database connection and requesting for Data with search parameters
    $con = new DB();
    $data = $con->searchData($name, $option);

    // Returning requested data as json
    echo json_encode($data);
}
if (isset($_POST["user"])) {

    $id = $_POST["user"];
    // Creating Database connection and requesting for Data with search parameters
    $con = new DB();
    $data = $con->viewCart($id);

    // Returning requested data as json
    echo json_encode($data);
}
