<?php
session_start();
include "./connect.php";
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $deta = json_decode(file_get_contents("php://input"), true);

    if ($deta == null || !isset($deta["email"]) || !isset($deta["password"])) {
        http_response_code(400);
        $response = array(
            "message" => "Data not provided properly",
            "status" => "failed"
        );
        echo json_encode($response);
    } else {
        $email = $deta["email"];
        $password = md5($deta["password"]);


        $query = $pdo->prepare("SELECT password FROM users WHERE email = :email");
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result !== false && $password === $result["password"]) {
            http_response_code(200);
            $_SESSION["userid"] = $email;
            $response = array(
                "message" => "success",
                "redirect" => "./index.html",
                "status" => "success"
            );
            echo json_encode($response);
        } else {
            http_response_code(401);
            $response = array(
                "message" => "Incorrect email or password",
                "status" => "error"
            );
            echo json_encode($response);
        }
    }
} else {
    http_response_code(405);
    $response = array(
        "message" => "Method not allowed",
        "status" => "error"
    );
    echo json_encode($response);
}