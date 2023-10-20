<?php
$dbname = "./scores.db";
$db = new PDO("sqlite:".$dbname);

header("Access-Control-Allow-Origin: *");

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$getScoresSql = "SELECT * FROM scores ORDER BY score DESC;";
$intStmt = $db->prepare($getScoresSql);
if ($intStmt->execute()) {
    $result = $intStmt->fetchAll(PDO::FETCH_ASSOC);
    header("Content-Type: application/json");
    echo json_encode($result);
    return;
}