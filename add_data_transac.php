<?php
    include 'db_connection.php';
    try {
        $conn->beginTransaction(); // Insert data transactionally
        // SQL statements
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Mary', 'Moe', 'mary@example.com')");
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Julie', 'Dooley', 'julie@example.com')");
        $conn->exec("INSERT INTO MyGuests (firstname, lastname, email) VALUES ('Sulyy', 'Pauly', 'xyz@example.com')");

        // commit the transaction
        $conn->commit();
        echo "New records created successfully"; // Success message
    } catch (PDOException $e) {
        // rollback the transaction if something failed
        $conn->rollBack();
        echo "Error: " . $e->getMessage(); // Error message
    }
    $conn = null; // Close connection
?>