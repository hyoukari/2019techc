<?php
// ログイン名とパスワードが期待したものでない場合はフォームに戻す
if (
    empty($_POST["login_name"]) || empty($_POST["pass"])
    || strlen($_POST["login_name"]) < 3 || 20 < strlen($_POST["login_name"])
    || strlen($_POST["pass"]) < 6 || 100 < strlen($_POST["pass"])
) {
    header("HTTP/1.1 302 Found");
    header("Location: ./login_form.php?error=1");
    return;
}

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

$stmt = $dbh->prepare("SELECT * FROM users WHERE name=:login_name");
$stmt->execute(array(
    ":login_name" => $_POST["login_name"]
));
$rows = $stmt->fetchAll();

if (empty($rows)) {
    // ログイン名が正しくない場合
    header("HTTP/1.1 302 Found");
    header("Location: ./index.php?error=1");
    return;
}

$user = $rows[0];

if (!password_verify($_POST["pass"], $user["pass"])) {
    // パスワードが正しくない場合
    header("HTTP/1.1 302 Found");
    header("Location: ./index.php?error=1");
    return;
}
// セッション開始
session_start();
// セッションパラメータ user_login_name にユーザー名格納
$_SESSION["user_login_name"] = $user["name"];
// ログイン完了
header("HTTP/1.1 303 See Other");
header("Location: ./login_finish.php");
