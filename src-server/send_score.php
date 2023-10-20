<?php
$dbname = "./scores.db";
$db = new PDO("sqlite:".$dbname);

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$insertSql = "INSERT INTO scores (name, affilication, score) VALUES (:name, :affilication, :score);";
if ($intStmt = $db->prepare($insertSql)) {
    if (!isset($data["name"]) || !isset($data["affilication"]) || !isset($data["point"])) {
        http_response_code(400);
        echo "invalid data";
        return;
    }

    $intStmt->bindParam(':name', $data['name']);
    $intStmt->bindParam(':affilication', $data['affilication']);
    $intStmt->bindParam(':score', $data['point']);

    if ($intStmt->execute()) {
        http_response_code(200);
        echo "success";
        return;
    }
}

http_response_code(400);
echo "invalid input";