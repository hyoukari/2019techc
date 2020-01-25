<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login finish</title>
</head>

<body>
    <h1>ログイン完了</h1>
    <hr>
    ユーザー:
    <?php echo ($_SESSION["user_login_name"]); ?>
    でログイン完了しました。<br>
    <a href="./read.php">掲示板に戻る</a>
</body>

</html>
