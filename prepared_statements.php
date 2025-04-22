<?php
    include 'db_connection.php';

    try{
        // Prepare a statement
        $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");

        // Bind parameters
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);   
        $stmt->bindParam(':email', $email);

        // Insert first row
        $firstname = "Roy";
        $lastname = "Moe";
        $email = "rory@gmail.com";
        $stmt->execute();

        // Insert second row
        $firstname = "Jason";
        $lastname = "Smith";
        $email = "jason@yahoo.com";
        $stmt->execute();

        echo "New records created successfully"; // Success message
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Error message
    }
    $conn = null; // Close connection
?>