<?php

include 'connect.php';

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $checkEmail = "SELECT * From users where email='$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) {
        echo "Email Address Already Exists !";
    } else {
        $insertQuery = "INSERT INTO users(firstName,lastName,email,password)
                       VALUES ('$firstName','$lastName','$email','$password')";
        if ($conn->query($insertQuery) == TRUE) {
            header("location: index.php");
        } else {
            echo "Error:" . $conn->error;
        }
    }


}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' and password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];

        // Send a request to the Node.js server to run npm start
        $ch = curl_init('http://localhost:3000/start');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        header("Location: http://localhost:3000/book");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>