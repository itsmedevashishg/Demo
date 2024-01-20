<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$insert = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "trip";

    $con = new mysqli($server, $username, $password, $database);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $info = $_POST['info'];

    //$stmt = $con->prepare("INSERT INTO `trip` (`name`, `age`, `gender`, `email`, `phone`, `other`, `dt`) VALUES (?, ?, ?, ?, ?, ?, current_timestamp())");
    $stmt = $con->prepare("INSERT INTO `trip` (`sno`, `name`, `age`, `gender`, `email`, `phone`, `other`, `dt`) VALUES (NULL, ?, ?, ?, ?, ?, ?, current_timestamp())");

    if ($stmt === false) {
        echo "Error in preparing statement";
    } else {
        $stmt->bind_param("ssssss", $name, $age, $gender, $email, $phone, $info);

        if ($stmt->execute()) {
            $insert = true;
        } else {
            echo "Error in execution: " . $stmt->error;
        }

        $stmt->close();
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Travel Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <img class="bg" src="bg.jpg" alt="NIT Kurukshetra">
    <div class="container">
        <h1>Welcome to NIT Kurukshetra Chandigarh Trip form</h1>
        <p>Enter your details and submit this form to confirm your participation in the trip </p>
        <?php
        if ($insert) {
            echo "<p class='submitMsg'>Thanks for submitting your form. We are happy to see you joining us for the Chandigarh trip</p>";
        }
        ?>
        <form action="" method="post">
            <input type="text" name="name" id="name" placeholder="Enter your name" required>
            <input type="text" name="age" id="age" placeholder="Enter your Age" required>
            <input type="text" name="gender" id="gender" placeholder="Enter your gender" required>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            <input type="text" name="phone" id="phone" placeholder="Enter your phone" required>
            <textarea name="info" id="info" cols="30" rows="10" placeholder="Enter any other information here"></textarea>
            <button class="btn">Submit</button> 
        </form>
    </div>
    <script src="index.js"></script>
</body>
</html>
