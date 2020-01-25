<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login page</title>
</head>

<body>
    <h1>ログイン</h1>
    <hr>
    会員登録は<a href="./register_form.php">こちら</a>
    <hr>
    <?php
    if ($_GET['error'] === "1") {
        print("ログインに失敗しました。正しいログイン名とパスワードを入力してください。");
    }
    ?>
    <form action="login.php" method="post">
        NAME: <input type="text" name="login_name" id="login_name"><br>
        PW: <input type="password" name="password" id="password"><br>
        <button type="submit">ログイン</button>
    </form>
</body>

</html>
