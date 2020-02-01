<?php
session_start();
// csrf対策
$token_length = 16;
$tokenByte = openssl_random_pseudo_bytes($token_length);
$csrfToken = bin2hex($tokenByte);
$_SESSION["csrfToken"] = $csrfToken;

// database
// $dbhost = "database-1.cmjpznuslfdx.us-east-1.rds.amazonaws.com";
// $dbname = "test";
$dbhost = "db";
$dbname = "hyoukaridb";
$user = "app_username";
$pass = "app_password";
$dsn = "mysql:host={$dbhost}; dbname={$dbname};";
try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    return var_dump($e);
    echo "Error: {$e->getMessage()}¥n";
}

$stmt = $dbh->prepare("SELECT forum.id, forum.name, forum.content, forum.image_path, forum.create_at, users.user_icon
                        FROM forum
                        LEFT JOIN users
                        ON forum.name=users.login_name
                        ORDER BY forum.id");
$stmt->execute();
$result = $stmt->fetchAll();
// var_dump($result);

// 内容表示
echo "<h1>" . "掲示板" . "</h1>";

echo "<button type=\"button\" onclick=\"location.href='./profile.php'\">プロフィール</button><br>";
echo "<button type=\"button\" onclick=\"location.href='./index.php'\">ログアウト</button><br>";

foreach ($result as $value) {
    echo "<p>";
    echo $value["id"] . " : " . "<img src='{$value["user_icon"]}' width='30' height='30' />" . " : " . ($value["name"] ? htmlspecialchars_decode($value["name"], ENT_QUOTES) : "名無しさん") . " : " . htmlspecialchars($value["create_at"], ENT_QUOTES) . "<br>";
    echo $value["content"] . "<br>";
    if (isset($value["image_path"])) {
        echo "<img class='img' src='{$value["image_path"]}'>";
    }
    echo "</p>";
}


require_once("read.html");
