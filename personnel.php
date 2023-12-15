<?php

include 'inc/fonction.php';

//预处理
$requete = $pdo->prepare("SELECT * FROM personnel");
$requete->execute();
$personnels = $requete->fetchAll();


//搜索参数
$conditions = [];
$params = [];


//搜索国家
if (isset($_GET['nom_equipe']) && $_GET['nom_equipe'] != '') {
    $conditions[] = "id_equipe = ?";
    $params[] = $_GET['nom_equipe'];
}

//搜索角色
if (isset($_GET['role']) && $_GET['role'] != '') {
    $conditions[] = "role = ?";
    $params[] = $_GET['role'];
}

// 根据筛选条件构建SQL查询
if (count($conditions) > 0) {
    $sqlConditions = ' WHERE ' . implode(' AND ', $conditions);
    $requete = $pdo->prepare("SELECT * FROM personnel" . $sqlConditions);
    $requete->execute($params);
    $personnels = $requete->fetchAll();
} else {
    $requete = $pdo->prepare("SELECT * FROM personnel");
    $requete->execute();
    $personnels = $requete->fetchAll();
}

// 查询所有团队
$equipeQuery = $pdo->prepare("SELECT id_equipe, nom_equipe FROM equipe");
$equipeQuery->execute();
$equipes = $equipeQuery->fetchAll(PDO::FETCH_ASSOC);

// 查询所有角色
$roleQuery = $pdo->prepare("SELECT DISTINCT role FROM personnel");
$roleQuery->execute();
$roles = $roleQuery->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['idPersonnel'])){

     // SQL查询字符串，将数据插入到名为 "equipe" 的数据库表中
     $query = "INSERT INTO personnel VALUES(NULL, :prenom, :nom, :sexe, :role, :idEquipe)";
     // 创建一个 PDO 预处理语句对象
     $stmt = $pdo->prepare($query);
     // 这段代码是用于执行一个带有绑定参数的数据库查询，主要用于将从一个 HTML 表单通过 POST 方法提交的数据插入到数据库表中。

     // 执行准备好的语句，将实际的数值绑定到占位符上，完成数据的插入
     $stmt->execute([
     "prenom" => $_POST['prenomPersonnel'], 
     "nom" => $_POST['nomPersonnel'], 
     "sexe" => $_POST['sexePersonnel'], 
     "role" => $_POST['rolePersonnel'], 
     "idEquipe" => $_POST['idEquipe'], 
     ]);
     // 在成功插入数据后，使用 header 函数进行页面重定向，将用户导向名为 "equipe.php" 的页面
     header("location: personnel.php");
     // 终止脚本的执行，确保在执行页面重定向后不再继续执行后续的 PHP 代码
     exit;

}else if(isset($_GET["action"])){
    $action = $_GET["action"];

    switch($action){
        case "update":
            $requete = $pdo->prepare("SELECT * FROM personnel WHERE id_personnel = ?");
            $requete->execute([$_GET['id_personnel']]);
            $personnelUp = $requete->fetch();

            break;
            case "delete":
                $stmt = $pdo->prepare("DELETE FROM personnel WHERE id_personnel = ?");
                $stmt->execute([$_GET['id_personnel']]);

            header("location: personnel.php");
            exit;
    }
}
include 'inc/header.php';
include 'view/vuePersonnel.phtml';
include 'inc/footer.php';



?>