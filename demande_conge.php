<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usere_basserh");

if (isset($_POST['demande_conge'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $poste = $_POST['poste'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $type_conge = $_POST['type_conge'];

    $stmt = $conn->prepare("INSERT INTO demande_conge (nom, prenom, poste, date_debut, date_fin, type_conge, etat) VALUES (?, ?, ?, ?, ?, ?, 'en attente')");
    $stmt->bind_param("ssssss", $nom, $prenom, $poste, $date_debut, $date_fin, $type_conge);
    $stmt->execute();

    header("Location: confirmation.php"); // صفحة شكر مثلا
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Demande de Congé</title>
    <link rel="stylesheet" href="benh.css">
</head>
<body>

<h2 style="text-align:center;">Bienvenue, <?= htmlspecialchars($_SESSION['employe_nom']) ?></h2>

<form method="post" action="submit_demande.php" style="width:400px; margin:auto;">
     <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>
    <input type="text" name="poste" placeholder="Poste" required>
    <label>Date de début :</label>
    <input type="date" name="date_debut" required>
    <label>Date de fin :</label>
    <input type="date" name="date_fin" required>
    <label>Type de congé :</label>
    <select name="type_conge" required>
        <option value="annuel">Congé annuel</option>
        <option value="maladie">Congé maladie</option>
        <option value="exceptionnel">Congé exceptionnel</option>
    </select>
    <button type="submit" name="demande_conge">Envoyer</button>
</form>

<a class="logout" href="logout.php">Se déconnecter</a>

</body>
</html>
