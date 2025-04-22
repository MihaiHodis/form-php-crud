<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "testdb";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); // Create connection
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>