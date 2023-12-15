<?php

include 'inc/fonction.php';

$requete = $pdo->prepare("SELECT * FROM equipe");
$requete->execute();
$equipes = $requete->fetchAll();



// INSERTION
// Determine if a variable is declared and is different than NULL isset( mixed $var [, mixed $... ]): bool

if (isset($_POST['idEquipe'])){

     // SQL查询字符串，将数据插入到名为 "equipe" 的数据库表中
     $query = "INSERT INTO equipe VALUES(NULL, :nomequipe)";
     // 创建一个 PDO 预处理语句对象
     $stmt = $pdo->prepare($query);
     // 这段代码是用于执行一个带有绑定参数的数据库查询，主要用于将从一个 HTML 表单通过 POST 方法提交的数据插入到数据库表中。

     // 执行准备好的语句，将实际的数值绑定到占位符上，完成数据的插入
     $stmt->execute([
     "nomequipe" => $_POST['nomEquipe'], 
     ]);
     // 在成功插入数据后，使用 header 函数进行页面重定向，将用户导向名为 "equipe.php" 的页面
     header("location: equipe.php");
     // 终止脚本的执行，确保在执行页面重定向后不再继续执行后续的 PHP 代码
     exit;

}else if(isset($_GET["action"])){
    $action = $_GET["action"];

    switch($action){
        case "update":
            $requete = $pdo->prepare("SELECT * FROM equipe WHERE id_equipe = ?");
            $requete->execute([$_GET['id_equipe']]);
            $equipeUp = $requete->fetch();

            break;
            case "delete":
                $stmt = $pdo->prepare("DELETE FROM equipe WHERE id_equipe = ?");
                $stmt->execute([$_GET['id_equipe']]);

            header("location: equipe.php");
            exit;
    }
}

include 'inc/header.php';
include 'view/vueEquipe.phtml';
include 'inc/footer.php';



?>