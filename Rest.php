<?php
include('../db.php');
class Rest{
    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "products";      
    private $productTable = 'products';	
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }

	// Endpoint for postman is localhost/api/endpoint/create.php
	function insertProduct($data){ 		
		$con = mysqli_connect("localhost","root","","products");
	    if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
		}
		$title=$data["title"];
		$desc=$data["desc"];
		$quantity=$data["quantity"];
		$price=$data["price"];		
		$image=$data["image"];
		$sql = "INSERT INTO ".$this->productTable." (title, `desc`, image, quantity, price)
VALUES ('".$title."', '".$desc."', '".$image."',".$quantity.",".$price.")";
		if( mysqli_query($con, $sql)) {
			$messgae = "Product created Successfully.";
			$status = 1;			
		} else {
			$messgae = "Product creation failed.";
			$status = 0;			
		}
		$prodResponse = array(
			'status' => $status,
			'status_message' => $messgae
		);
		header('Content-Type: application/json');
		echo json_encode($prodResponse);
	}
}
?>