<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="Register">
        <button><a href="login.php">login</a></button>
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        
        echo "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $conn = new mysqli('localhost', 'root', '', 'user_registration');
       
        if ($conn->connect_error)
        
             {die("Connection failed: " . $conn->connect_error);}
        
        $statement  = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
       
        $statement ->bind_param("sss", $name, $email, $hashed_password);
        
        if ($statement ->execute()) {
            echo "Registration successful!";
        
        } else {
            echo "Error: " . $stmt->error;
        
        }
        $statement ->close();
         
        $conn->close();
       
    }
}
?>
