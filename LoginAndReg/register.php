<?php

include 'connect.php';

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fname']; // Ensure correct form input names
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash the password before storing it
    $hashedPassword = md5($password);

    // Check if the email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email already exists";
    } else {
        // Insert the new user
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password)
                        VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";

        if ($conn->query($insertQuery) === TRUE) {
            // Redirect to login page after successful registration
            header("Location: Login.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash the password before checking with the database
    $hashedPassword = md5($password);

    // Select user with the matching email and hashed password
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Start session and store user email in the session
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        
        // Redirect to the homepage after successful login
        header("Location: ../HomePage/HomePage.php");
        exit();
    } else {
        echo '<script>
        alert("Login failed. Incorrect email or password");
        window.location.href = "login.php";
    </script>';
    }
}
?>
