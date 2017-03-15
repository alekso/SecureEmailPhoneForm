<?php
//require connection files
include_once "../src/app/config.php";
include_once "../src/app/DB.php";

$conn=DB::connect();

$table="CREATE TABLE IF NOT EXISTS tbl_contacts (
          id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, 
          email VARCHAR(255) NOT NULL,
          phone VARCHAR(255) NOT NULL
        )";

try{
    $conn->query($table);
    echo "Table created"."<br />";
} catch (PDOException $ex){
    echo "A database error occurred".$ex->getMessage()."<br />";
    error_log("A database error occurred".$ex->getMessage(), 0);
}