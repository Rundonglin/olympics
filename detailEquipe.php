<?php

$pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_projet_olympics", "root", "");
$pdo->exec("SET NAMES UTF8");
$id_cmd = $_GET['id'];



$query = "SELECT id_personnel, prenom, nom, sexe, 'role'
          FROM personnel
          INNER JOIN equipe
          ON personnel.id_equipe = equipe.id_equipe
          WHERE nom_equipe = ?";

$stmt = $pdo->prepare($query);
$stmt ->execute(array($id_cmd));
$clients = $stmt->fetchAll();
var_dump($id_cmd); 
var_dump($clients);






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
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="equipe.php">Equipe</a></li>
            <li><a class="dropdown-item" href="personnel.php">Personnel</a></li>
            <li><hr class="dropdown-divider"></li>
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

    <h1 class="text-success">Equipe <?php echo $id_cmd?> </h1>
    <a href="equipe.php">Retour</a>

        <table class="table table-success table-striped">
            <tr class="table-dark">
                <th>ID de personnel</th>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Sexe</th>
                <th>Role</th>
            </tr>
        <!-- 在PHP中，as是将遍历的数组内元素用一个替身变量表示的意思，as是在foreach语句中使用的，是一种遍历数组的方法，语法为“foreach (array_expression as $value){语句}”。 -->

            <tr>
                <td><?php echo $clients['id_personnel'] ?></td>
                <td><?php echo $clients['prenom'] ?></td>
                <td><?php echo $clients['nom'] ?> </td>
                <td><?php echo $clients['sexe'] ?> </td>
                <td><?php echo $clients['role'] ?> </td>
            </tr>


        </table>


</body>
</html>
