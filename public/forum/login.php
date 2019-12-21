<?php
// if ($_SERVER["REQUEST_METHOD" == "post"]) {
//     exit;
// } elseif ($_SERVER["REQUEST_METHOD" == "get"]) {
//     exit;
// } else {
//     exit;
// }
?>

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
    <form action="login.php" method="post">
        NAME: <input type="text" name="name" id="name"><br>
        PW: <input type="password" name="pass" id="pass"><br>
        <button type="submit">ログイン</button>
    </form>
</body>

</html>