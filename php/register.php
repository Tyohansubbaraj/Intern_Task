<?php
include "connections.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    // Retrieve POST data with HTML special characters
    $firstName = htmlspecialchars($data['first_name']);
    $middleName = htmlspecialchars($data['middle_name']);
    $lastName = htmlspecialchars($data['last_name']);
    $mobileNo = htmlspecialchars($data['mobile_no']);
    $dob = htmlspecialchars($data['dob']);
    $email = htmlspecialchars($data['email']);
    $password = htmlspecialchars($data['password']);
    $confirmPassword = htmlspecialchars($data['confirm_password']);

    // Check if any data other than middle name is empty
    if (empty($firstName) || empty($lastName) || empty($mobileNo) || empty($dob) || empty($email) || empty($password) || empty($confirmPassword)) {
        $response = ["status" => "error", "message" => "All fields are required"];
        echo json_encode($response);
        exit();
    }

    // Password hashing
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Database connection parameters for MySQL
    // $servername = "localhost";
    // $username = "root";
    // $dbpassword = "";
    // $dbname = "Internship_Task";

    // // Connect to MySQL
    // $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // if ($conn->connect_error) {
    //     $response = ["status" => "error", "message" => "Database connection failed: " . $conn->connect_error];
    //     echo json_encode($response);
    //     exit();
    // }

    // // Check if email already exists
    $db = new mysqlconnection();
    $sconn = $db->getConnection();
    $stmt = $sconn->prepare("SELECT * FROM logindata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $response = ["status" => "error", "message" => "Email already in use"];
        echo json_encode($response);
        exit();
    }

    $stmt = $sconn->prepare("INSERT INTO logindata (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()==true) {
        
        $userDetails = [
            'email' => $email,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'mobile_no' => $mobileNo,
            'dob' => $dob,
        ];

        $mconn = new MongoDB("Intern_Task", "User_Details");
        $mconn->insert($userDetails);

        
        $sconn->close();

        $response = ["status" => "success", "message" => "Registration successful"];
        echo json_encode($response);
        exit();
    } else {
        $response = ["status" => "error", "message" => "Error: " . $stmt->error];
        echo json_encode($response);
        exit();
    }
}
