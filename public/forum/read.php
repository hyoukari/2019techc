<?php

// csrf対策
$token_length = 16;
$tokenByte = openssl_random_pseudo_bytes($token_length);
$csrfToken = bin2hex($tokenByte);
$_SESSION["csrfToken"] = $csrfToken;

// database
$dbhost = "database-1.cmjpznuslfdx.us-east-1.rds.amazonaws.com";
$dbname = "test";
$dsn = "mysql:host={$dbhost}; dbname={$dbname};";
$user = "admin";
$pass = "password";
try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Error: {$e->getMessage()}¥n";
}

$stmt = $dbh->prepare("SELECT * FROM forum");
$stmt->execute();
$result = $stmt->fetchAll();
// var_dump($result);

// 内容表示
echo "<h1>" . "掲示板" . "</h1>";

foreach ($result as $value) {
    echo "<p>";
    echo $value["id"] . " : " . ($value["name"] ? htmlspecialchars_decode($value["name"], ENT_QUOTES) : "名無しさん") . " : " . htmlspecialchars($value["create_at"], ENT_QUOTES) . "<br>";
    echo $value["content"] . "<br>";
    if (isset($value["image_path"])) {
        echo "<img class='img' src='{$value["image_path"]}'>";
    }
    echo "</p>";
}

require_once("index.html");
