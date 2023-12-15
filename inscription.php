<?php
// 创建PDO连接
$pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_projet_olympics", "root", "",[
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
// $pdo: 这是一个表示与数据库连接的PDO对象.exec(): 是PDO对象的一个方法，用于执行不返回结果集的SQL语句。
// 这是一个SQL语句，用于设置数据库连接的字符集为UTF-8。字符集是指定义了用于存储和检索数据的字符编码规则。UTF-8是一种通用的字符编码，支持多种语言的字符。
$pdo -> exec("SET NAMES UTF8");
// try块包含可能引发异常的代码。catch块用于捕获和处理特定类型的异常。你可以有多个catch块来处理不同类型的异常。
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 处理注册表单提交
    $username = $_POST['username'];
    // 使用哈希密码为了安全性
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
// 插入用户数据到数据库
        $stmt = $pdo->prepare('INSERT INTO admin (id, login, mdp) VALUES (NULL, ?, ?)');
        $stmt->execute([$username, $password]);

        echo 'Enregistrement réussi！ <br>';
        echo '<a href="login.php">Retour à la page de connexion</a>';

    
    } catch (PDOException $e) {
        echo 'Enregistrement pas réussi：' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Olympics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">JEUX OLYMPICS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>

        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">SITE 2023-2024</a>
        </li>
      </ul>
      </form>
    </div>
  </div>
</nav>
</header>
<body>
    <h2>Inscription</h2>
    <form action="inscription.php" method="post">
        <label for="username">Login:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

<?php
include 'inc/footer.php'

?>