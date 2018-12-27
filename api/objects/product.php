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
    
        // query to insert record
        /*$query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);*/
    
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        /*$stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
        else return false;*/

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

}