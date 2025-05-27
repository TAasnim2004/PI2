<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usere_basserh");

if (isset($_POST['demande_id'], $_POST['action'])) {
    $id = $_POST['demande_id'];
    $etat = ($_POST['action'] === 'accepter') ? 'accepté' : 'refusé';

    $stmt = $conn->prepare("UPDATE demande_conge SET etat = ? WHERE id = ?");
    $stmt->bind_param("si", $etat, $id);
    $stmt->execute();

    header("Location: admin_panel.php");
    exit;
}
?>
