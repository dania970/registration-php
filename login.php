<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    if (empty($email) || empty($password)) {
        echo "Both fields are required.";
        
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        echo "Invalid email format.";
       
    } else {
        
        $conn = new mysqli('localhost', 'root', '', 'user_registration');

     

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
    
        }

      
        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
       

        $stmt->bind_param("s", $email);
        

        $stmt->execute();
       

        $stmt->store_result();
        

        if ($stmt->num_rows > 0) {
            

            $stmt->bind_result($hashed_password);
            

            $stmt->fetch();
            

            if (password_verify($password, $hashed_password)) {
                echo "Login successful!";
              
            } else {
                echo "Incorrect password.";
                
            }
        } else {
            echo "No account found with that email.";
            
        }

        $stmt->close();
        

        $conn->close();
        
    }
}
?>

