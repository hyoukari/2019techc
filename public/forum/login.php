<?php
// ログイン名とパスワードが期待したものでない場合はフォームに戻す
if (
    empty($_POST["login_name"]) || empty($_POST["password"])
    || strlen($_POST["login_name"]) < 3 || 20 < strlen($_POST["login_name"])
    || strlen($_POST["password"]) < 6 || 100 < strlen($_POST["password"])
) {
    header("HTTP/1.1 302 Found");
    header("Location: ./index.php?error=1");
    return;
}

// database
$dbhost = "db";
$dbname = "hyoukaridb";
$user = "app_username";
$pass = "app_password";
$dsn = "mysql:host={$dbhost}; dbname={$dbname};";
try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Error: {$e->getMessage()}¥n";
}

$stmt = $dbh->prepare("SELECT * FROM users WHERE login_name=:login_name");
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

if (!password_verify($_POST["password"], $user["password"])) {
    // パスワードが正しくない場合
    header("HTTP/1.1 302 Found");
    header("Location: ./index.php?error=1");
    return;
}
// セッション開始
session_start();
// セッションパラメータ user_login_name にユーザー名格納
$_SESSION["user_login_name"] = $user["login_name"];
// ログイン完了
header("HTTP/1.1 303 See Other");
header("Location: ./login_finish.php");
