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
    
    if ($stmt->execute()) {
        echo "<script>alert('Demande envoyée avec succès !'); window.location.href='demande_conge.php';</script>";
    } else {
        echo "Erreur : " . $conn->error;
    }
}
?>
