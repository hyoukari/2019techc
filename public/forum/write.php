<?php
if (empty($_POST["body"])) {
    header("Location: read.php");
}

//
$name = !empty($_POST["name"]) ? htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8") : "";
$content = !empty($_POST["content"]) ? htmlspecialchars($_POST["content"], ENT_QUOTES, "UTF-8") : "";

// ファイルのアップロード処理
$filename = null;
// ファイルの存在確認
if ($_FILES['upload_image']['size'] > 0) {
    // 画像かどうかのチェック
    if (exif_imagetype($_FILES['upload_image']['tmp_name'])) {
        // アップロードされたファイルの元々のファイル名から拡張子を取得
        $ext = pathinfo($_FILES['upload_image']['name'], PATHINFO_EXTENSION);
        // ランダムな値でファイル名を生成
        $filename = uniqid() . "." . $ext;
        $filepath = "../static/images/" . $filename;
        // ファイルを保存
        move_uploaded_file($_FILES['upload_image']['tmp_name'], $filepath);
    }
}
// $image_filepath = null;
//$upload_image = $_FILES["image"];
//if ($upload_image["size"] > 0) {
// アップロードファイル画像チェック
//    if (!exif_imagetype($upload_image["tmp_name"])) {
//        print("アップロードできるファイルは画像のみです");
//        return;
//    }
// 拡張子を取得する
//    $ext = pathinfo($upload_image['name'], PATHINFO_EXTENSION);
// 保管するファイル名をきめる。被らないように時刻+ランダムな数値にする。
//    $image_filename = sprintf("%d_%d.%s", time(), rand(100000, 999999), $ext);
// 保管するファイルパスをきめる。
//    $image_filepath = '~/2019techc/public/static/images/' . $image_filename;
// ファイルを一時ファイルからコピーし，保存する。
//  copy($upload_image['tmp_name'], $image_filepath);

// ブラウザからの表示用のパスを設定。この値をDBにつっこむ。
//    $image_view_path = '/static/images/' . $image_filename;
//}


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
if ($_POST["csrfToken"] === $_SESSION["csrfToken"]) {
    if (!empty($content) || !empty($filepath)) {
        $stmt = $dbh->prepare("INSERT INTO forum(name, content, image_path) VALUES(:name, :content, :image_path)");
        $stmt->execute([
            ":name" => $name,
            ":content" => $content,
            ":image_path" => $filepath,
        ]);
    }
} else {
    // CSRF攻撃発生sss
}


header("Location: read.php");
