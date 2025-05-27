<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usere_basserh");

$result = $conn->query("SELECT * FROM demande_conge WHERE etat = 'en attente'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Validation des Congés</title>
    <link rel="stylesheet" href="benh.css">
</head>
<body>

<h2 style="text-align:center;">Demandes en attente</h2>

<?php while($row = $result->fetch_assoc()) { ?>
    <form method="post" action="valider_demande.php" style="width:400px; margin:auto; margin-bottom: 30px;">
        <p><strong><?= htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) ?></strong><br>
        Du <?= $row['date_debut'] ?> au <?= $row['date_fin'] ?><br>
        Type : <?= $row['type_conge'] ?></p>

        <input type="hidden" name="demande_id" value="<?= $row['id'] ?>">
        <input type="text" name="admin_nom" placeholder="Nom RH" required>
        <input type="text" name="admin_prenom" placeholder="Prénom RH" required>

        <button type="submit" name="action" value="accepter">Accepter</button>
        <button type="submit" name="action" value="refuser">Refuser</button>
    </form>
<?php } ?>

</body>
</html>
