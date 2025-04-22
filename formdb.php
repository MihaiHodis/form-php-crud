<?php
include 'db_connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Procesare formular
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);

    if (empty($firstname) || empty($lastname) || empty($email)) {
        echo "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            echo "<div class='alert alert-success'>New record created successfully</div>";

            header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page to avoid form resubmission
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Actiune de stergere
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM MyGuests WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "<div class='alert alert-danger'>Record deleted successfully</div>";
        header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page to avoid form resubmission
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form with Database Connection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Formular PHP cu conexiune la baza de date</h1>
    <p>Fill in the form below to insert data into the database.</p>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="firstname">Enter first name:</label>
        <input type="text" id="firstname" name="firstname" class="form-control"><br>
        <label for="lastname">Enter last name:</label>
        <input type="text" id="lastname" name="lastname" class="form-control"><br>
        <label for="email">Enter email:</label>
        <input type="email" id="email" name="email" class="form-control"><br>
        <input type="submit" value="Submit" class="btn btn-primary">
    </form>

    <h2 class="mt-5">Data from Database</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $stmt = $conn->prepare("SELECT id, firstname, lastname, email FROM MyGuests");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($stmt->fetchAll() as $row) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Sigur vrei sa stergi acest rand?\")'>Delete</a></td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>