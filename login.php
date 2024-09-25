<!doctype html>
<html lang="zh_tw">
<head>
<meta charset="utf-8">
<title>登入成果</title>
</head>
<body>
<h3>登入成果</h3>
<?php
session_start();

// 建立與資料庫的連線
$link = new PDO('mysql:dbname=h801;host=localhost;', 'h801', 'M7rtPka5#');

// 從表單取得註冊資料
$name = str_replace("'", "''", $_REQUEST['id']);
$pwd1 = str_replace("'", "''", $_REQUEST['pwd']);
$pwd = sha1($pwd1);  // 使用 SHA-1 加密密碼

// 檢查是否有相同帳號存在
$checkQuery = "SELECT * FROM person WHERE name = '$name' and pwd='${pwd}'";
$checkResult = $link->query($checkQuery);
if ($checkResult->rowCount() != 1) {
    echo '登入錯誤<br/>'.$checkResult->rowCount();
} else {
        $_SESSION['login'] = 1;
        $_SESSION['id'] = $name;
        echo '登入中...';
        echo '<script>window.location.href = "test.php";</script>';  // 跳轉到首頁
}

// 關閉資料庫連線
$link = null;
?>
</body>
</html>
