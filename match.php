<?php
include 'inc/fonction.php';



// 准备并执行一个SQL查询，从'rencontre'表中选择所有记录。
$requete = $pdo->prepare("SELECT * FROM rencontre");
$requete->execute();
// 从查询结果中获取所有行，并将它们存储在$matchs数组中。
$matchs = $requete->fetchAll();


// 获取当前时间
$currentDateTime = new DateTime();

// 根据筛选条件查询比赛
$filterOption = $_GET['filter_option'] ?? '';

if ($filterOption === 'upcoming') {
    // 查询即将到来的比赛
    $requete = $pdo->prepare("SELECT * FROM rencontre WHERE date_rencontre > ?");
    $requete->execute([$currentDateTime->format('Y-m-d H:i:s')]);
    $matchs = $requete->fetchAll();
} elseif ($filterOption === 'no_upcoming') {
    // 查询没有即将到来的比赛的球队
    $requete = $pdo->prepare("
        SELECT e.nom_equipe
        FROM equipe e
        WHERE NOT EXISTS (
            SELECT 1 FROM rencontre r WHERE (r.id_equipe_a = e.id_equipe OR r.id_equipe_b = e.id_equipe) AND date_rencontre > ?
        )
    ");
    $requete->execute([$currentDateTime->format('Y-m-d H:i:s')]);
    $matchs = $requete->fetchAll();

} else {
    // 默认显示所有比赛
    $requete = $pdo->prepare("SELECT * FROM rencontre");
    $requete->execute();
    $matchs = $requete->fetchAll();
    // 在成功插入后重定向到'match.php'页面。

}

// 检查是否提交了表单。
if (isset($_POST['submit'])){
    // 准备一个SQL语句，用于向'rencontre'表中插入一条新记录。
    $query = "INSERT INTO rencontre(lieu, type, id_equipe_a, id_equipe_b, date_rencontre) 
              VALUES(:lieu, :type, :idEquipeA, :idEquipeB, :date)";

    // 创建一个预处理语句，以防止SQL注入。
    $stmt = $pdo->prepare($query);

    // 使用来自表单的值执行预处理语句。
    // 确保为'type'、'idEquipeA'和'idEquipeB'提供的值在各自的表中有效且存在。
    $stmt->execute([
        "lieu" => $_POST['lieu'],
        "type" => $_POST['type'], // 确保这个值在`type_discipline`表中存在
        "idEquipeA" => $_POST['idEquipeA'], // 确保这个值有效且非空
        "idEquipeB" => $_POST['idEquipeB'], // 确保这个值有效且非空
        "date" => $_POST['dateRencontre'],
    ]);

    // 在成功插入后重定向到'match.php'页面。
    header("location: match.php");
    exit;
} else if(isset($_GET["action"])){
    // 从查询字符串中获取动作类型。
    $action = $_GET["action"];

    // 根据动作类型处理不同的操作。
    switch($action){
        case "update":
            // 准备并执行一个查询，从'rencontre'表中获取特定记录。
            $requete = $pdo->prepare("SELECT * FROM rencontre WHERE id_rencontre = ?");
            $requete->execute([$_GET['id_rencontre']]);
            // 获取用于更新操作的记录。
            $matchUp = $requete->fetch();

            break;

        case "delete":
            // 首先，删除'resultat_match'表中引用要删除的'id_rencontre'的任何记录。
            $stmtDeleteResultatMatch = $pdo->prepare("DELETE FROM resultat_match WHERE id_rencontre = ?");
            $stmtDeleteResultatMatch->execute([$_GET['id_rencontre']]);

            // 然后，从'rencontre'表中删除该记录。
            $stmtDeleteRencontre = $pdo->prepare("DELETE FROM rencontre WHERE id_rencontre = ?");
            $stmtDeleteRencontre->execute([$_GET['id_rencontre']]);

            // 在成功删除后重定向到'match.php'。
            header("location: match.php");
            exit;
    }
}

// 包含头部、视图和页脚的PHP文件。
include 'inc/header.php';
include 'view/vueMatch.phtml';
include 'inc/footer.php';