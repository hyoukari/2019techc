<?php
// ログイン名とパスワードが期待したものでない場合はフォームに戻す
if (
    empty($_POST['login_name']) || empty($_POST['password'])
    || strlen($_POST['login_name']) < 3 || strlen($_POST['login_name']) > 20
    || strlen($_POST['password']) < 6 || strlen($_POST['password']) > 100
) {
    header("HTTP/1.1 302 Found");
    header("Location: ./register_form.php?error=1");
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
$select_stn = $dbh->prepare("SELECT COUNT(id) FROM users WHERE login_name=:login_name");
$select_stn->execute(array(
    ":login_name" => $_POST["login_name"]
));
$rows = $select_stn->fetchAll();
if ($rows[0][0] !== "0") {
    // 同じログインIDのユーザーが既にある場合はフォームに戻す
    header("HTTP/1.1 302 Found");
    header("Location: ./register_form.php?error=2");
    return;
}

// パスワードのハッシュ化
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
// INSERTする
$insert_sth = $dbh->prepare("INSERT INTO users (login_name, password) VALUES (:login_name, :password)");
$insert_sth->execute(array(
    ":login_name" => $_POST["login_name"],
    ":password" => $password,
));
// 投稿が完了したので閲覧画面に飛ばす
header("HTTP/1.1 303 See Other");
header("Location: ./register_finish.php");
