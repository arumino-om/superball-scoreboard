<?php
$dbname = "./scores.db";
echo $dbname;
$db = new PDO("sqlite:" . $dbname);

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$createDB = "CREATE TABLE IF NOT EXISTS scores(name TEXT, affilication TEXT, score INTEGER)";

try {
    $res = $db->exec($createDB);
    http_response_code(204);
    return;

} catch (PDOException $e) {
    http_response_code(500);
    echo "create error";
    return;
}

http_response_code(400);
echo "invalid input";