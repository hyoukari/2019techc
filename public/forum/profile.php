<?php
session_start();
// csrf対策
$token_length = 16;
$tokenByte = openssl_random_pseudo_bytes($token_length);
$csrfToken = bin2hex($tokenByte);
$_SESSION["csrfToken"] = $csrfToken;
//
$login_user = $_SESSION['user_login_name'];
// DB準備
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
// プリペアドステートメント
$stmt = $dbh->prepare("SELECT forum.id, forum.name, forum.content, forum.image_path, forum.create_at, users.user_icon
                        FROM forum
                        LEFT JOIN users
                        ON forum.name=users.login_name
                        WHERE forum.name=:login_user
                        ORDER BY forum.id");
$stmt->execute([":login_user" => $login_user]);
$result = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../static/style.css">
    <title>Forum/Profile</title>
</head>

<body>
    <h1>プロフィール</h1>
    <button type="button" onclick="location.href='./read.php'">掲示板に戻る</button> <br>
    ユーザー：<?php echo $login_user ?><br>
    <form action="changeicon.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="{$csrfToken}">
        <span>
            <button>ユーザーアイコン変更</button><input type="file" name="upload_icon" id="upload_icon" accept="image/*">
        </span>
    </form>
    <h2>投稿一覧</h2>
    <?php
    foreach ($result as $value) {
        echo "<p>";
        echo $value["id"] . " : " . "<img src='{$value["user_icon"]}' width='30' height='30' />" . " : " . ($value["name"] ? htmlspecialchars_decode($value["name"], ENT_QUOTES) : "名無しさん") . " : " . htmlspecialchars($value["create_at"], ENT_QUOTES) . "<br>";
        echo $value["content"] . "<br>";
        if (isset($value["image_path"])) {
            echo "<img class='img' src='{$value["image_path"]}'>";
        }
        echo "</p>";
    }
    ?>
</body>

</html>
