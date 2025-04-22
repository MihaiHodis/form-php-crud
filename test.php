
<html>

<body>
    <div>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>



    <?php
    include 'db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST["name"]);
        $email = htmlspecialchars($_POST["email"]);

        if (!empty($name) && !empty($email)) {
            echo "<h1 style='color:blue;'>";
            echo "Hello $name, your email is $email.";
            echo "</h1>";
        } else {
            echo "Please fill in both fields.";
        }
    }
    ?>
</body>

</html>