<?php

$pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_projet_olympics", "root", "");
$pdo->exec("SET NAMES UTF8");
$id_cmd = $_GET['id'];


// 准备一个SQL查询，用于从personnel表和equipe表中获取数据
// 这个查询通过INNER JOIN联结两个表，并根据提供的国家名（nom_equipe）过滤结果
$query = "SELECT id_personnel, prenom, nom, sexe, role
          FROM personnel
          INNER JOIN equipe
          ON personnel.id_equipe = equipe.id_equipe
          WHERE nom_equipe = ?";

// 使用PDO准备SQL语句。这是一种安全的方法，可以防止SQL注入攻击
$stmt = $pdo->prepare($query);

// 执行准备好的语句，传入来自URL参数的国家名（$id_cmd）
$stmt->execute(array($id_cmd));

// 从查询结果中获取所有行，并将它们存储在$clients数组中
// 使用PDO::FETCH_ASSOC模式，结果将作为关联数组返回，其中列名是键名
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    </body>
</html>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="equipe.php">Equipe</a></li>
                            <li><a class="dropdown-item" href="personnel.php">Personnel</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>

<body class="container">

<h1 class="text-success">Equipe <?php echo $id_cmd ?> </h1>
<a href="equipe.php">Retour</a>
<table class="table table-success table-striped">
    <tr class="table-dark">
        <th>ID de personnel</th>
        <th>Prenom</th>
        <th>Nom</th>
        <th>Sexe</th>
        <th>Role</th>
    </tr>
    <?php foreach ($clients as $client): ?>
        <tr>
            <td><?php echo htmlspecialchars($client['id_personnel']); ?></td>
            <td><?php echo htmlspecialchars($client['prenom']); ?></td>
            <td><?php echo htmlspecialchars($client['nom']); ?></td>
            <td><?php echo htmlspecialchars($client['sexe']); ?></td>
            <td><?php echo htmlspecialchars($client['role']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
