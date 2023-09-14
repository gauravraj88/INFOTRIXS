<?php

session_start();

include "./connect.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data === null) {
        $response = array(
            "message" => "No data Found",
            "status" => "error"
        );
        echo json_encode($response);
    }

    $email = $data['email'];
    $name = $data['name'] . " " . $data['surname'];
    $date = $data['date'];
    $gender = $data['gender'];
    $password = md5($data['password']);

    $query = $pdo->prepare("INSERT INTO users (email,name,date_of_birth,gender,password) VALUES (:email,:name,:date,:gender,:password)");
    $query->bindParam(":email", $email);
    $query->bindParam(":name", $name);
    $query->bindParam(":date", $date);
    $query->bindParam(":gender", $gender);
    $query->bindParam(":password", $password);

    if ($query->execute()) {
        $_SESSION["userid"] = $email;
        $response = array(
            "message" => "success",
            "redirect" => "./index.html",
            "status" => "done"
        );
        echo json_encode($response);
    } else {
        $response = array(
            "message" => "failed",
            "status" => "Some problem in the query"
        );
        echo json_encode($response);
    }
}