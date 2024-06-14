<?php
include "connections.php";
// require 'C:/xampp/htdocs/GUVI/vendor/autoload.php'; // Include the MongoDB library
$mconn = new MongoDB("Intern_Task", "User_Details");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);
    $action = $data['action'];

    if ($action == 'getProfile') {
        // Fetch user profile
        $email = $data['email'];

        if (empty($email)) {
            echo json_encode(["status" => "error", "message" => "Email is required"]);
            exit();
        }

        try {

            $user = $mconn->find(['email' => $email]);
            if ($user) {
                $response = ["status" => "success", "data" => $user];
                echo json_encode($response);
            } else {
                echo json_encode(["status" => "error", "message" => "User not found"]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error fetching user details: " . $e->getMessage()]);
        }
    } elseif ($action == 'updateProfile') {
        // Update user profile
        $email = $data['email'];
        $firstName = htmlspecialchars($data['first_name']);
        $middleName = htmlspecialchars($data['middle_name']);
        $lastName = htmlspecialchars($data['last_name']);
        $mobileNo = htmlspecialchars($data['mobile_no']);
        $dob = htmlspecialchars($data['dob']);

        if (empty($email) || empty($firstName) || empty($lastName) || empty($mobileNo) || empty($dob)) {
            echo json_encode(["status" => "error", "message" => "All fields except middle name are required"]);
            exit();
        }

        try {
            $updation = ['$set' => [
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'mobile_no' => $mobileNo,
                'dob' => $dob
            ]];
            $updateResult = $mconn->update(['email' => $email], $updation);

            if ($updateResult->getModifiedCount() > 0) {
                echo json_encode(["status" => "success", "message" => "Profile updated successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "No changes were made"]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Error updating profile: " . $e->getMessage()]);
        }
    } elseif ($action == 'logout') {

        $email = $data['email'];
        $rconn = new redisconnection();

        $rconn->delete($email);

        echo json_encode(["status" => "success", "message" => "Logout successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
