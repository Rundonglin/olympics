<?php
// session_start() 是 PHP 中用于启动会话（session）的函数。会话是一种在服务器端存储用户数据的机制，
// 可以用于跟踪用户的状态，存储用户信息等。必须在页面中其他任何输出之前调用，通常放在 PHP 脚本的顶部。
// 一旦调用了 session_start()，就可以使用 $_SESSION 超全局数组来存储和检索会话数据。$_SESSION 是服务器端的会话数据存储位置，可以在页面之间共享。
session_start();
// 创建PDO连接
$pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_projet_olympics", "root", "",[
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
// $pdo: 这是一个表示与数据库连接的PDO对象.exec(): 是PDO对象的一个方法，用于执行不返回结果集的SQL语句。
// 这是一个SQL语句，用于设置数据库连接的字符集为UTF-8。字符集是指定义了用于存储和检索数据的字符编码规则。UTF-8是一种通用的字符编码，支持多种语言的字符。
$pdo -> exec("SET NAMES UTF8");
// $_SERVER 是一个包含了服务器信息的 PHP 超全局数组。$_SERVER['REQUEST_METHOD'] 包含了当前请求的 HTTP 方法（GET、POST、等）。
// 'POST' 是 HTTP 方法，表示客户端发送了一个 POST 请求。
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 处理登录表单提交.$_POST 是 PHP 中的一个关联数组，用于从 POST 请求中获取用户提交的数据。
   // 'username' 是一个表单字段的名称，通常用于收集用户输入的用户名。
  // $username 是一个 PHP 变量，用于存储从 POST 请求中获取的用户名数据，以便在后续的代码中使用。
    $username = $_POST['username'];
    $password = $_POST['password'];


    // 从数据库中获取用户信息
    $stmt = $pdo->prepare('SELECT id, login, mdp FROM admin WHERE login = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // 验证密码
    if ($user && password_verify($password, $user['mdp'])) {
        $_SESSION['user_id'] = $user['id'];
        echo 'Connexion réussie！';
        echo "<a href='accueil.php'>Aller à la page d'accueil</a><br>";
        echo "<a href='logout.php'>Déconnexion</a>";

    } else {
        echo 'login ou mot de passe incorrect！';
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
    <h2>Connexion</h2>
    <form action="login.php" method="post">
        <label for="username">Login:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">submit</button>
    </form>
</body>
</html>

<?php
include 'inc/footer.php'

?>