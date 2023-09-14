<?php
session_start();
include "./connect.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $response = array();
    if (isset($_SESSION["userid"])) {
        $response["logged"] = $_SESSION["userid"];
    }
    $query = $pdo->prepare("SELECT * FROM messages");
    $query->execute();
    $messages = $query->fetchAll(PDO::FETCH_ASSOC);

    $response["email"] = array_column($messages, "email");
    $response["name"] =  array_column($messages, "sender_name");
    $response["messages"] =  array_column($messages, "msg");
    $response["time"] =  array_column($messages, "time");

    echo json_encode($response);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data != null && isset($data['email']) && isset($data['message'])) {

        $email = $data['email'];
        $msg = $data['message'];
        $time =  date('Y-m-d H:i:s');
        $query = $pdo->prepare("SELECT name FROM users WHERE email=:email");
        $query->bindParam(':email', $email);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $name = $result['name'];
            $secquery = $pdo->prepare("INSERT INTO messages (email,sender_name,msg,time) VALUES (:email,:name,:message,:time)");
            $secquery->bindParam(':email', $email);
            $secquery->bindParam(':name', $name);
            $secquery->bindParam(':message', $msg);
            $secquery->bindParam(':time', $time);

            if ($secquery->execute()) {
                $response = array(
                    "message" => "success"
                );
                echo json_encode($response);
            } else {
                $response = array(
                    "message" => "Error inserting message"
                );
                echo json_encode($response);
            }
        } else {
            $response = array(
                "message" => "User not found"
            );
            echo json_encode($response);
        }
    } else {
        $response = array(
            "message" => "Invalid data sent"
        );
        echo json_encode($response);
    }
}