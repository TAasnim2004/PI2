<?php
session_start();
$conn = new mysqli("localhost", "root", "", "usere_basserh");

$error_rh = "";
$error_employe = "";
$error_admin = "";

// Connexion RH
if (isset($_POST['rh_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM rh WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: mondh.php");
        exit;
    } else {
        $error_rh = "Identifiants incorrects";
    }
}

// Connexion Employé
if (isset($_POST['employe_login'])) {
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM employees WHERE nom=? AND password=?");
    $stmt->bind_param("ss", $nom, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['employe_nom'] = $nom;
        header("Location: demande_conge.php");
        exit;
    } else {
        $error_employe = "Nom ou mot de passe incorrect";
    }
}
// Connexion Admin
if (isset($_POST['admin_login'])) {
    $admin_nom = $_POST['nom'];
$admin_password = $_POST['password'];


    $stmt = $conn->prepare("SELECT * FROM admin WHERE nom=? AND mot_de_passe=?");
    $stmt->bind_param("ss", $admin_nom, $admin_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin_nom'] = $admin_nom;
        header("Location: dashboard_admin.php");
        exit;
    } else {
        $error_admin = "Identifiants admin incorrects";
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="benh.css">
</head>
<body>

<div class="container">
    <nav>
        <a class="logo" href="#">RHSmart</a>
        <ul>
            <li><a href="#Service_RH">Service RH</a></li>
            <li><a href="#Employes">Employés</a></li>
            <li><a href="#admin">Admin</a></li>
        </ul>
    </nav>
</div>

<!-- Formulaire RH -->
<div class="login-wrapper" id="Service_RH">
    <div class="login-card">
        <div class="login-image">
            <img src="projet.jpg" alt="Login Image">
        </div>
        <div class="login-form">
            <h2>Connexion RH</h2>
            <?php if (!empty($error_rh)) echo "<p style='color:red;'>$error_rh</p>"; ?>
            <form method="post">
                <label>Nom d'utilisateur :</label>
                <input type="text" name="username" required>
                <label>Mot de passe :</label>
                <input type="password" name="password" required>
                <button type="submit" name="rh_login">Se connecter</button>
            </form>
        </div>
    </div>
</div>

<!-- Formulaire Employé -->
<div class="login-wrapper" id="Employes">
    <div class="login-card">
        <div class="login-form">
            <h2>Connexion Employé</h2>
            <?php if (!empty($error_employe)) echo "<p style='color:red;'>$error_employe</p>"; ?>
            <form method="post">
                <label>Nom :</label>
                <input type="text" name="nom" required>
                <label>Mot de passe :</label>
                <input type="password" name="password" required>
                <button type="submit" name="employe_login">Se connecter</button>
            </form>
        </div>
    </div>
</div>

<!-- Formulaire Admin -->
<div class="login-wrapper" id="admin">
    <div class="login-card">
        <div class="login-form">
            <h2>Connexion Admin</h2>
            <?php if (!empty($error_admin)) echo "<p style='color:red;'>$error_admin</p>"; ?>
            <form method="post">
                <label>Nom :</label>
                <input type="text" name="nom" required>
                <label>Mot de passe :</label>
                <input type="password" name="password" required>
<button type="submit" name="admin_login">Se connecter</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
