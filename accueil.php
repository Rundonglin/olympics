<?php
include 'inc/fonction.php';
include 'inc/header.php';

// 假设 'date_rencontre' 是存储比赛日期的字段
$query = "SELECT r.id_rencontre, r.date_rencontre, e1.nom_equipe as equipe_a, e2.nom_equipe as equipe_b
          FROM rencontre r
          JOIN equipe e1 ON r.id_equipe_a = e1.id_equipe
          JOIN equipe e2 ON r.id_equipe_b = e2.id_equipe
          WHERE r.date_rencontre > NOW()"; // 只选择未来的比赛
$stmt = $pdo->prepare($query);
$stmt->execute();
$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>


<div>
    <a href="logout.php" class="btn btn-lg btn-secondary">Déconnexion</a>
</div>

<!-- 即将到来的比赛表格 -->
    <h2 style="text-align: center;">Matchs à venir</h2>
    <table class="table table-success table-striped table-hover">
        <thead>
        <tr>
            <th>ID Rencontre</th>
            <th>Date Rencontre</th>
            <th>Equipe A</th>
            <th>Equipe B</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($matches as $match): ?>
            <tr>
                <td><?= htmlspecialchars($match['id_rencontre']); ?></td>
                <td><?= htmlspecialchars($match['date_rencontre']); ?></td>
                <td><?= htmlspecialchars($match['equipe_a']); ?></td>
                <td><?= htmlspecialchars($match['equipe_b']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</body>


<?php include 'inc/footer.php'; ?>
