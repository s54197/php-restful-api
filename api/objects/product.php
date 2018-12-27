<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "products";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){

        // select all query
        $query = "SELECT
                        c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                    FROM
                        " . $this->table_name . " p
                        LEFT JOIN
                            categories c
                                ON p.category_id = c.id
                    ORDER BY
                        p.created DESC";

        //$result = $this->conn->query($sql);
        $result = mysqli_query($this->conn,$query);
        return $result;

    }

    // create product
    function create(){
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->created=htmlspecialchars(strip_tags($this->created));

        $query = "INSERT INTO $this->table_name (name,price,description,category_id,created) 
                    VALUES (
                        '$this->name',
                        '$this->price',
                        '$this->description',
                        '$this->category_id',
                        '$this->created'
                    )";

        if (mysqli_query($this->conn,$query)) return true;
        return false;
        
    }

    function readOne(){

        // query to read single record
        $query = "SELECT
                        c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                    FROM
                        $this->table_name p
                        LEFT JOIN
                            categories c
                                ON p.category_id = c.id
                    WHERE
                        p.id = $this->id
                    LIMIT
                        0,1";

        $result = mysqli_query($this->conn,$query);
        $row = mysqli_fetch_array($result);

        // set values to object properties
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }

}