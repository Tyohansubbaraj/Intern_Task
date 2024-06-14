<?php
include "connections.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate email and password
        if (empty($email) || empty($password)) {
            echo json_encode(["status" => "error", "message" => "Email and password are required"]);
            exit();
        } else {
            $db = new mysqlconnection();
            $sconn = $db->getConnection();
            $hashedpassword = '';
            $stmt = $sconn->prepare("SELECT password FROM logindata WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($hashedpassword);
            $stmt->fetch();
            $stmt->close();
            $sconn->close();


            if ($hashedpassword && password_verify($password, $hashedpassword)) {
                $rconn = new redisconnection();

                $rconn->set($email, json_encode(['email' => $email, 'password' => $hashedpassword]));

                echo json_encode(["status" => "success", "message" => "Login successful"]);
                exit();
            } else {

                echo json_encode(["status" => "error", "message" => "Invalid email or password"]);
                exit();
            }
        }
    } else {

        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        exit();
    }
} else {

    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit();
}
