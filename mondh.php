<?php
session_start();
if (!isset($_SESSION['username'])) {
    
    header("Location: mouka.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "usere_basserh");

$msg_ajout = "";
$msg_conge = "";

// Ajout d'un employé
if (isset($_POST['ajouter_employe'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $poste = $_POST['poste'];
    $salaire = $_POST['salaire'];

    $stmt = $conn->prepare("INSERT INTO employees (nom, prenom, poste, salaire) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $nom, $prenom, $poste, $salaire);
    $stmt->execute();
    $msg_ajout = "Employé ajouté avec succès.";
}

// Demande de congé
if (isset($_POST['demande_conge'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $poste = $_POST['poste'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $type_conge = $_POST['type_conge'];

    $stmt = $conn->prepare("INSERT INTO demandes_conge (nom, prenom, poste, date_debut, date_fin, type_conge) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nom, $prenom, $poste, $date_debut, $date_fin, $type_conge);
    $stmt->execute();
    $msg_conge = "Demande envoyée avec succès.";
}

$result = $conn->query("SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord RH</title>
    <link rel="stylesheet" href="benh.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h2, h3 {
            text-align: center;
        }

        form {
            width: 400px;
            margin: 30px auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 12px;
            background-color: #f9f9f9;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="date"],
        form select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #aaa;
            border-radius: 6px;
            font-size: 16px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        form button:hover {
            background-color: #45a049;
        }

        .message {
            color: green;
            text-align: center;
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 30px auto;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        .logout {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

    </style>
</head>
<body>

<h2>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?></h2>

<!-- Formulaire d'ajout d'employé -->
<h3>Ajouter un employé</h3>
<?php if (!empty($msg_ajout)) echo "<p class='message'>$msg_ajout</p>"; ?>
<form method="post">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>
    <input type="text" name="poste" placeholder="Poste" required>
    <button type="submit" name="ajouter_employe">Ajouter</button>
</form>

<!-- Liste des employés -->
<h3>Liste des employés</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Poste</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['prenom']) ?></td>
            <td><?= htmlspecialchars($row['poste']) ?></td>
        </tr>
    <?php } ?>
</table>


</body>
</html>
