<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>

<body>
    <h1>登録フォーム</h1>
    <hr>
    <?php
    if ($_GET["error"] === "2") {
        print("既に同じログイン名のユーザーが存在します。別のログイン名を入力してください。");
    }
    ?>
    <form action="./register.php" method="post" enctype="multipart/form-data">
        <div>
            NAME: <input type="text" name="login_name" minlength="3" maxlength="20">
        </div>
        <div>
            PW: <input type="password" name="pass" minlength="6" maxlength="100">
        </div>
        <input type="submit" value="登録">
    </form>
</body>

</html>
