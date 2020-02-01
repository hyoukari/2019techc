<?php
session_start();
if (empty($_POST["body"])) {
    header("Location: profile.php");
}

$login_user = (string) $_SESSION['user_login_name'];

// ファイルのアップロード処理
$filename = null;
// ファイルの存在確認
if ($_FILES['upload_icon']['size'] > 0) {
    // 画像かどうかのチェック
    if (exif_imagetype($_FILES['upload_icon']['tmp_name'])) {
        // アップロードされたファイルの元々のファイル名から拡張子を取得
        $ext = pathinfo($_FILES['upload_icon']['name'], PATHINFO_EXTENSION);
        // ランダムな値でファイル名を生成
        $filename = "i" . uniqid() . "." . $ext;
        $filepath = "../static/images/" . $filename;
        // ファイルを保存
        move_uploaded_file($_FILES['upload_icon']['tmp_name'], $filepath);
    }
}

// database
$dbhost = "db";
$dbname = "hyoukaridb";
$user = "app_username";
$pass = "app_password";
$dsn = "mysql:host={$dbhost}; dbname={$dbname}";
try {
    $dbh = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Error: {$e->getMessage()}¥n";
}

// 書き込み
// if ($_POST["csrfToken"] === $_SESSION["csrfToken"]) {
if (!empty($filepath)) {
    $stmt = $dbh->prepare("UPDATE users
                            SET user_icon=:icon_path
                            WHERE login_name=:login_user");
    $r = $stmt->execute([
        ":icon_path" => $filepath,
        ":login_user" => $login_user,
    ]);
}
var_dump($r);
// } else {
//     // CSRF攻撃発生sss
// }

header("Location: profile.php");
