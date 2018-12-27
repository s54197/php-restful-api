<?php
// required headers
header("Access-Control-Allow-Origin: *");       //file can be read by anyone (asterisk * means all)
header("Content-Type: application/json; charset=UTF-8");        //return a data in JSON format
 
// include database and object files
include_once "../config/database.php";
include_once "../objects/product.php";

// instantiate database and product object
$database = New Database();
$db = $database->getConnection();

// initialize object
$product = new Product($db);

// read products will be here
$stmt = $product->read();
$num = mysqli_num_rows($stmt);

if($num>0){
 
    // products array
    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = mysqli_fetch_array($stmt)){
        extract($row);
 
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );
 
        array_push($products_arr["records"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($products_arr);
    
}
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
